<?php

namespace App\Tests\Controller\Module\WebShop\External\Cart;

use App\Entity\OrderHeader;
use App\Entity\OrderItem;
use App\Factory\OrderHeaderFactory;
use App\Factory\OrderItemFactory;
use App\Factory\ProductFactory;
use App\Service\Module\WebShop\External\Cart\Session\CartSessionProductService;
use App\Tests\Fixtures\CurrencyFixture;
use App\Tests\Fixtures\CustomerFixture;
use App\Tests\Fixtures\LocationFixture;
use App\Tests\Fixtures\PriceFixture;
use App\Tests\Fixtures\ProductFixture;
use App\Tests\Utility\FindByCriteria;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Browser;
use Zenstruck\Browser\Test\HasBrowser;

class CartControllerTest extends WebTestCase
{
    use HasBrowser, CurrencyFixture, CustomerFixture, ProductFixture, PriceFixture,
        LocationFixture,FindByCriteria;

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
                $order =$this->findOneBy(OrderHeader::class,['customer' => $this->customer->object()]);

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
                $order =$this->findOneBy(OrderHeader::class,['customer' => $this->customer->object()]);

                $item = $this->findOneBy(OrderItem::class,['orderHeader' => $order,
                                                'product' => $this->productA->object()]);

                $this->assertEquals($this->priceValueOfProductA, $item->getPricePerUnit());
            })
            ->visit($uriAddProductB)
            ->fillField('cart_add_product_single_form[productId]', $this->productB->getId())
            ->fillField(
                'cart_add_product_single_form[quantity]', 2
            )
            ->click('Add To Cart')
            ->use(function (Browser $browser) {

                // Test : An order got created
                $order =$this->findOneBy(OrderHeader::class,['customer' => $this->customer->object()]);

                $item = $this->findOneBy(OrderItem::class,['orderHeader' => $order,
                                                'product' => $this->productB->object()]);

                $this->assertEquals($this->priceValueOfProductB, $item->getPricePerUnit());
            })
            ->assertSuccessful()
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

                // Test : An order got created
                $order = $this->findOneBy(OrderHeader::class,['customer' => $this->customer->object()]);

                $itemA = $this->findOneBy(OrderItem::class,['orderHeader' => $order,
                                                 'product' => $this->productA->object()]);

                $this->assertEquals(4, $itemA->getQuantity());

                $itemB = $this->findOneBy(OrderItem::class,['orderHeader' => $order,
                                                 'product' => $this->productB->object()]);

                $this->assertEquals(6, $itemB->getQuantity());

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


                // Test : An order got created
                $order =$this->findOneBy(OrderHeader::class,['customer' => $this->customer->object()]);

                $itemA = $this->findOneBy(OrderItem::class,['orderHeader' => $order,
                                                 'product' => $this->productA->object()]);

                $this->assertNull($itemA);

                $itemB =$this->findOneBy(OrderItem::class,['orderHeader' => $order,
                                                 'product' => $this->productB->object()]);

                $this->assertNotNull($itemB);

            })
            // clear cart
            ->visit($clearCartUri)
            ->use(function (\Zenstruck\Browser $browser) {
                $session = $browser->client()->getRequest()->getSession();

                // Test: Cart is cleared
                $this->assertNull($session->get(CartSessionProductService::CART_SESSION_KEY));

                $order =$this->findOneBy(OrderHeader::class,['customer' => $this->customer->object()]);
                $itemA = $this->findOneBy(OrderItem::class,['orderHeader' => $order,
                                                 'product' => $this->productA->object()]);
                $this->assertNull($itemA);

                $itemB = $this->findOneBy(OrderItem::class,['orderHeader' => $order,
                                                 'product' => $this->productB->object()]);

                $this->assertNull($itemB);


            })
            ->assertSuccessful();

    }
}
