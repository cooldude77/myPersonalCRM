<?php

namespace App\Tests\Controller\Module\WebShop\External\CheckOut;

use App\Factory\CustomerFactory;
use App\Factory\PinCodeFactory;
use App\Factory\UserFactory;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Browser;
use Zenstruck\Browser\Test\HasBrowser;

class CheckOutControllerTest extends WebTestCase
{
    use HasBrowser;

    public function testCheckoutWhenNotLoggedIn()
    {
        $uri = "/checkout";
        $this
            ->browser()
            ->visit($uri)
            ->assertNotAuthenticated()
            ->assertSee('Login')
            ->assertSee('Sign Up To Proceed');
    }

    public function testCheckoutWhenLoggedIn()
    {
        $user = UserFactory::createOne(['login' => 'a@b.com']);

        $customer = CustomerFactory::createOne(['user' => $user]);


        $uri = "/checkout";
        $this->browser()
            ->use(function (Browser $browser) use ($user) {
                $browser->client()->loginUser($user->object());
            })
            ->visit($uri)
            ->assertSee('Create Shipping Address')
            ->assertSee('Create Billing Address');

    }

    public function testCheckoutAddShippingAddress()
    {
        $user = UserFactory::createOne(['login' => 'a@b.com']);

        $customer = CustomerFactory::createOne(['user' => $user]);

        $pinCode = PinCodeFactory::createOne();

        $uri = "/checkout";
        $this->browser()
            ->use(function (Browser $browser) use ($user) {
                $browser->client()->loginUser($user->object());
            })
            ->visit($uri)
            ->interceptRedirects()
            ->visit($uri)
            ->click('Create Shipping Address')
            ->followRedirects()
            ->fillField(
                'customer_address_create_form[line1]', 'Line 1'
            )
            ->fillField(
                'customer_address_create_form[line2]', 'Line 2'
            )
            ->fillField(
                'customer_address_create_form[line3]', 'Line 3'
            )
            ->fillField(
                'customer_address_create_form[addressType]', 'shipping'
            )
            ->use(function (Browser $browser) use ($pinCode) {
                $crawler = $browser->crawler();

                $domDocument = $crawler->getNode(0)?->parentNode;

                $option = $domDocument->createElement('option');
                $option->setAttribute('value', $pinCode->getId());
                $selectElement = $crawler->filter('select')->getNode(0);
                $selectElement->appendChild($option);
            })
            ->interceptRedirects()
            ->click('Save')
            ->followRedirect()
            ->assertOn('/checkout')
            ->assertSee('Edit this address');


    }

    public function testCheckoutAddBillingAddress()
    {
        $user = UserFactory::createOne(['login' => 'a@b.com']);

        $customer = CustomerFactory::createOne(['user' => $user]);

        $pinCode = PinCodeFactory::createOne();

        $uri = "/checkout";
        $this->browser()
            ->use(function (Browser $browser) use ($user) {
                $browser->client()->loginUser($user->object());
            })
            ->visit($uri)
            ->interceptRedirects()
            ->visit($uri)
            ->click('Create Shipping Address')
            ->followRedirects()
            ->fillField(
                'customer_address_create_form[line1]', 'Line 1'
            )
            ->fillField(
                'customer_address_create_form[line2]', 'Line 2'
            )
            ->fillField(
                'customer_address_create_form[line3]', 'Line 3'
            )
            ->fillField(
                'customer_address_create_form[addressType]', 'billing'
            )
            ->use(function (Browser $browser) use ($pinCode) {
                $crawler = $browser->crawler();

                $domDocument = $crawler->getNode(0)?->parentNode;

                $option = $domDocument->createElement('option');
                $option->setAttribute('value', $pinCode->getId());
                $selectElement = $crawler->filter('select')->getNode(0);
                $selectElement->appendChild($option);
            })
            ->interceptRedirects()
            ->click('Save')
            ->followRedirect()
            ->assertOn('/checkout')
            ->assertSee('Edit this address');
    }
}
