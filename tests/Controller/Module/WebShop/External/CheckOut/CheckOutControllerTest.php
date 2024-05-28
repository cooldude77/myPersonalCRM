<?php

namespace App\Tests\Controller\Module\WebShop\External\CheckOut;

use App\Factory\CustomerAddressFactory;
use App\Service\Module\WebShop\External\Cart\Session\CartSessionService;
use App\Service\Module\WebShop\External\Cart\Session\Object\CartSessionObject;
use App\Tests\Fixtures\CustomerFixture;
use App\Tests\Fixtures\LocationFixture;
use App\Tests\Utility\MySessionFactory;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Browser;
use Zenstruck\Browser\Test\HasBrowser;

class CheckOutControllerTest extends WebTestCase
{
    use HasBrowser, CustomerFixture, LocationFixture;

    public function testCheckout()
    {
        $this->createLocationFixtures();
        $this->createCustomer();

        // without logging in
        // goto signup
        $uri = "/web-shop/checkout";
        $this
            ->browser()
            ->interceptRedirects()
            ->visit($uri)
            ->assertRedirectedTo('/web-shop/checkout/entry');

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
                $this->setDummyCart($browser);

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
                $this->setDummyCart($browser);
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
                $this->setDummyCart($browser);
            })
            ->interceptRedirects()
            ->visit($uri)
            ->assertRedirectedTo('/web-shop/order/create');

    }

    private function setDummyCart(KernelBrowser $browser): void
    {
        /** @var MySessionFactory $factory */
        $factory = $browser->getContainer()->get('session.factory');

        $session = $factory->createSession();
        $array = [new CartSessionObject(1, 4), new CartSessionObject(1.5)];
        $session->set(CartSessionService::CART_SESSION_KEY, $array);
        $session->save();
    }

}
