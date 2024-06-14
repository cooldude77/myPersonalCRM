<?php

namespace App\Tests\Controller\Module\WebShop\External\Cart;

use App\Factory\OrderHeaderFactory;
use App\Factory\OrderItemFactory;
use App\Factory\ProductFactory;
use App\Service\Module\WebShop\External\Cart\Session\CartSessionProductService;
use App\Tests\Fixtures\CurrencyFixture;
use App\Tests\Fixtures\CustomerFixture;
use App\Tests\Fixtures\LocationFixture;
use App\Tests\Fixtures\PriceFixture;
use App\Tests\Fixtures\ProductFixture;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Browser;
use Zenstruck\Browser\Test\HasBrowser;

class CartControllerTest extends WebTestCase
{
    use HasBrowser, CurrencyFixture, CustomerFixture, ProductFixture, PriceFixture, LocationFixture;

    public function testCart()
    {

        $this->createCustomer();
        $this->createProductFixtures();
        $this->createLocationFixtures();
        $this->createCurrencyFixtures($this->country);
        $this->createPriceFixtures($this->productA, $this->productB, $this->currency);

        $cartUri = '/cart';

        $uriAddProductA = "/cart/product/" . $this->productA->getId() . '/add';
        $uriAddProductB = "/cart/product/" . $this->productB->getId() . '/add';

        $clearCartUri = '/cart/clear';

        $cartDeleteUri = "/cart/product/" . $this->productA->getId() . '/delete';

        // Test : just visit cart
        $this->browser()
            // todo: don't allow cart when user is not logged in
            ->use(function (Browser $browser) {
                // log in User
                $browser->client()->loginUser($this->user->object());
            })
            ->visit($cartUri)
            ->use(function (Browser $browser) {
                $session = $browser->client()->getRequest()->getSession();

                // Test : Cart got created
                $this->assertNotNull($session->get(CartSessionProductService::CART_SESSION_KEY));
                // Todo: More tests
                // Test : An order got created
                $order = OrderHeaderFactory::find(['customer' => $this->customer]);
                $this->assertNotNull($order);

            })
            //Test :  add products to cart
            ->visit($uriAddProductA)
            ->fillField('cart_add_product_single_form[productId]', $this->productA->getId())
            ->fillField(
                'cart_add_product_single_form[quantity]', 1
            )
            ->click('Add To Cart')
            ->assertSuccessful()
            ->use(function (Browser $browser) {

                // Test : An order got created
                $order = OrderHeaderFactory::find(['customer' => $this->customer]);

                $item = OrderItemFactory::find(['orderHeader' => $order,
                                                  'product' => $this->productA]);

                $this->assertEquals($this->priceValueOfProductA,$item->getPricePerUnit());
            })

            ->visit($uriAddProductB)
            ->fillField('cart_add_product_single_form[productId]', $this->productB->getId())
            ->fillField(
                'cart_add_product_single_form[quantity]', 2
            )
            ->click('Add To Cart')
            ->use(function (Browser $browser) {

                // Test : An order got created
                $order = OrderHeaderFactory::find(['customer' => $this->customer]);

                $item = OrderItemFactory::find(['orderHeader' => $order,
                                                'product' => $this->productB]);

                $this->assertEquals($this->priceValueOfProductB,$item->getPricePerUnit());
            })
            ->assertSuccessful();
        /*
            // visit cart after update
            ->visit($cartUri)
            // update quantities
            ->fillField(
                'cart_multiple_entry_form[items][0][quantity]', 4
            )
            ->fillField(
                'cart_multiple_entry_form[items][1][quantity]', 6
            )
            // // todo: check for valid product ids in cart
            ->click("Update Cart")
            ->use(function (\Zenstruck\Browser $browser) {
                $session = $browser->client()->getRequest()->getSession();
                $cart = $session->get(CartSessionProductService::CART_SESSION_KEY);

                // Test: Cart has right items and quantities
                $this->assertEquals(4, $cart[$this->productA->getId()]->quantity);
                $this->assertEquals(6, $cart[$this->productB->getId()]->quantity);
                // Todo: More tests
            })
            // item delete from cart
            ->visit($cartDeleteUri)
            ->use(function (\Zenstruck\Browser $browser) {
                $session = $browser->client()->getRequest()->getSession();
                $cart = $session->get(CartSessionProductService::CART_SESSION_KEY);


                // Test: Product is removed from car
                $this->assertTrue(empty($cart[$this->productA->getId()]));

                // Test : Other product still exists
                $this->assertTrue(isset($cart[$this->productB->getId()]));
                // Todo: More tests
            })
            // clear cart
            ->visit($clearCartUri)
            ->use(function (\Zenstruck\Browser $browser) {
                $session = $browser->client()->getRequest()->getSession();

                // Test: Cart is cleared
                $this->assertNull($session->get(CartSessionProductService::CART_SESSION_KEY));
                // Todo: More tests
            })
            ->assertSuccessful();
*/
    }

    public function testDeleteItem()
    {
        $cartUri = '/cart';


        $product1 = ProductFactory::createOne(["name" => 'prod1']);
        $uri1 = "/cart/product/" . $product1->getId() . '/add';

        $product2 = ProductFactory::createOne(["name" => 'prod2']);
        $uri2 = "/cart/product/" . $product2->getId() . '/add';

        $cartDelete = "/cart/product/" . $product1->getId() . '/delete';

        // first add products to cart
        $this->browser()->visit($uri1)
            ->fillField('cart_add_product_single_form[productId]', $product1->getId())
            ->fillField(
                'cart_add_product_single_form[quantity]', 1
            )
            ->click('Add To Cart')->assertSuccessful()
            ->assertSuccessful()
            ->visit($uri2)
            ->fillField('cart_add_product_single_form[productId]', $product2->getId())
            ->fillField(
                'cart_add_product_single_form[quantity]', 2
            )
            ->click('Add To Cart')
            ->assertSuccessful()
            // check cart
            ->visit($cartUri)
            ->use(function (\Zenstruck\Browser $browser) {
                $session = $browser->client()->getRequest()->getSession();
                $this->assertNotNull($session->get(CartSessionProductService::CART_SESSION_KEY));
                // Todo: More tests
            })
            // update quantities
            ->fillField(
                'cart_multiple_entry_form[items][0][quantity]', 4
            )
            ->fillField(
                'cart_multiple_entry_form[items][1][quantity]', 6
            )
            // // todo: check for valid product ids in cart
            ->click("Update Cart")
            ->use(function (\Zenstruck\Browser $browser) use ($product1, $product2) {
                $session = $browser->client()->getRequest()->getSession();
                $cart = $session->get(CartSessionProductService::CART_SESSION_KEY);
                $this->assertEquals(4, $cart[$product1->getId()]->quantity);
                $this->assertEquals(6, $cart[$product2->getId()]->quantity);
                // Todo: More tests
            })
            // clear cart
            ->visit($cartDelete)
            ->use(function (\Zenstruck\Browser $browser) {
                $session = $browser->client()->getRequest()->getSession();
                $this->assertNull($session->get(CartSessionProductService::CART_SESSION_KEY));
                // Todo: More tests
            })
            ->assertSuccessful();

    }
}
