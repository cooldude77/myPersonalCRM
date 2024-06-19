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
    use HasBrowser, SessionFactoryFixture, ProductFixture,
        CustomerFixture, LocationFixture,
        CartFixture;

    public function testCheckout()
    {
        $this->createLocationFixtures();
        $this->createCustomer();
        $this->createProductFixtures();


        // without logging in
        // goto signup
        $uriCheckout = "/checkout";
        $this
            ->browser()
            ->visit($uriCheckout)
            ->assertOn('http://localhost/signup?_redirect_upon_success_url=/checkout', ['query']);

        // user is logged in
        // cart is empty
        $this
            ->browser()
            ->use(function (Browser $browser) {
                $browser->client()->loginUser($this->userForCustomer->object());
            })
            ->interceptRedirects()
            ->visit($uriCheckout)
            ->assertRedirectedTo('/cart')
            // fill cart and see it redirected to addresses
            ->use(function (KernelBrowser $browser) {
                $this->createSession($browser);
                $this->createCartInSession($this->session, $this->productA);

            })
            // addresses not created
            ->interceptRedirects()
            ->visit($uriCheckout)
            ->assertRedirectedTo('/checkout/addresses')
            ->use(function (KernelBrowser $browser) {

                // create shipping address
                CustomerAddressFactory::createOne(
                    ['customer' => $this->customer,
                     'addressType' => 'shipping',
                     'line1' => 'Shipping lane']
                );
            })

            // also need to create entry in session

            ->interceptRedirects()
            ->visit($uriCheckout)
            ->assertRedirectedTo('/checkout/addresses')
            ->use(function (KernelBrowser $browser) {

                // create shipping address
                CustomerAddressFactory::createOne(
                    ['customer' => $this->customer,
                     'addressType' => 'Billing',
                     'line1' => 'billing lane']
                );
            })
            ->visit($uriCheckout)
            ->assertSuccessful();


    }


}
