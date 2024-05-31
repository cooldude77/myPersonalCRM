<?php

namespace App\Tests\Controller\Module\WebShop\External\CheckOut;

use App\Factory\CustomerAddressFactory;
use App\Tests\Fixtures\CartFixture;
use App\Tests\Fixtures\CustomerFixture;
use App\Tests\Fixtures\LocationFixture;
use App\Tests\Fixtures\ProductFixture;
use App\Tests\Fixtures\SessionFactoryFixture;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Browser;
use Zenstruck\Browser\Test\HasBrowser;

class CheckOutControllerTest extends WebTestCase
{
    use HasBrowser, SessionFactoryFixture,ProductFixture, CustomerFixture, LocationFixture,
        CartFixture;

    public function testCheckout()
    {
        $this->createLocationFixtures();
        $this->createCustomer();
        $this->createProductFixtures();


        // without logging in
        // goto signup
        $uri = "/web-shop/checkout";
        $this
            ->browser()
            ->interceptRedirects()
            ->visit($uri)
            ->assertRedirectedTo('/checkout/entry');

        // user is logged in
        // cart is empty
        $this
            ->browser()
            ->use(function (Browser $browser) {
                $browser->client()->loginUser($this->user->object());
            })
            ->visit($uri)
            ->assertSee("Cart Is Empty");

        // cart is filled
        // addresses not in session
        $this->browser()
            ->use(function (KernelBrowser $browser) {

                $browser->loginUser($this->user->object());
                $this->createCartInSession($this->session,$this->product);

            })
            ->interceptRedirects()
            ->visit($uri)
            ->assertRedirectedTo('/web-shop/checkout/addresses');


        $addressShip = CustomerAddressFactory::createOne(
            ['customer' => $this->customer, 'addressType' => 'shipping', 'line1' => 'A Good House']
        );

        // first address in session
        $this->browser()
            ->use(function (KernelBrowser $browser) {

                $browser->loginUser($this->user->object());
                $this->createCartInSession($this->session,$this->product);
            })
            ->interceptRedirects()
            ->visit($uri)
            ->assertRedirectedTo('/checkout/addresses');

        $addressBill = CustomerAddressFactory::createOne(
            ['customer' => $this->customer, 'addressType' => 'shipping', 'line1' => 'A Good House']
        );

        // second address is in session
        $this->browser()
            ->use(function (KernelBrowser $browser) {

                $browser->loginUser($this->user->object());
                $this->createCartInSession($this->session,$this->product);
            })
            ->interceptRedirects()
            ->visit($uri)
            ->assertRedirectedTo('/web-shop/order/create');

    }


}
