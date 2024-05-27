<?php

namespace App\Tests\Controller\Module\WebShop\External\CheckOut;

use App\Factory\CustomerAddressFactory;
use App\Service\Module\WebShop\External\Cart\Session\CartSessionService;
use App\Service\Module\WebShop\External\Cart\Session\Object\CartSessionObject;
use App\Tests\Fixtures\CustomerFixture;
use App\Tests\Fixtures\LocationFixture;
use App\Tests\Utility\SessionFactory;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Zenstruck\Browser;
use Zenstruck\Browser\Test\HasBrowser;

class CheckOutControllerTest extends WebTestCase
{
    use HasBrowser, CustomerFixture, LocationFixture;

    public function testCheckoutWhenNotLoggedIn()
    {
        $this->createLocationFixtures();
        $this->createCustomer();

        $uri = "/web-shop/checkout";
        $this
            ->browser()
            ->interceptRedirects()
            ->visit($uri)
            ->assertRedirectedTo('/web-shop/checkout/entry');

        $this
            ->browser()
            ->use(function (Browser $browser) {
                $browser->client()->loginUser($this->user->object());
            })
            ->visit($uri)
            ->assertSee("Cart Is Empty");

        /** @var CartSessionService $cartService */
        /*  $cartService = $container->(CartSessionService::class);
          $cartObject = new CartSessionObject(1, 1);
          $cartService->addItemToCart($cartObject);
          */

        $this->browser()
            ->use(function (KernelBrowser $browser) {

                $browser->loginUser($this->user->object());
                /** @var SessionFactory $factory */
                $factory = $browser->getContainer()->get('session.factory');

                $session = $factory->createSession();
                $array = [ new CartSessionObject(1,4),new CartSessionObject(1.5)];
                $session->set(CartSessionService::CART_SESSION_KEY, $array);
                $session->save();
                $x = $session->get(CartSessionService::CART_SESSION_KEY);

            })
            ->use(
                function (ContainerInterface $container) {

                    /* $session = $container->get('session.factory');
                     $session->set('abc', 'xyz');
                     $session->save();

                     $x =  $session->get('abc');
                     $y=0;
                    */
                }
            )
            ->interceptRedirects()
            ->visit($uri)
            ->assertRedirectedTo('/web-shop/checkout/addresses');

        $addressShip = CustomerAddressFactory::createOne(
            ['customer' => $this->customer, 'addressType' => 'shipping', 'line1' => 'A Good House']
        );

        $this->browser()
            ->use(function (Browser $browser) {
                $browser->client()->loginUser($this->user->object());

            })
            ->interceptRedirects()
            ->visit($uri)
            ->assertRedirectedTo('/checkout/addresses');

        $addressBill = CustomerAddressFactory::createOne(
            ['customer' => $this->customer, 'addressType' => 'shipping', 'line1' => 'A Good House']
        );

        $this->browser()
            ->use(function (Browser $browser) {
                $browser->client()->loginUser($this->user->object());
            })
            ->interceptRedirects()
            ->visit($uri)
            ->assertRedirectedTo('/web-shop/order/create');

    }

}
