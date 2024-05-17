<?php

namespace App\Tests\Controller\Module\WebShop\External\Cart;

use App\Factory\ProductFactory;
use App\Service\Module\WebShop\External\Cart\CartService;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Browser\Test\HasBrowser;

class CartControllerTest extends WebTestCase
{
    use HasBrowser;

    public function testCart()
    {
        $cartUri = '/cart';


        $product1 = ProductFactory::createOne(["name" => 'prod1']);
        $uri1 = "/cart/product/" . $product1->getId() . '/add';

        $product2 = ProductFactory::createOne(["name" => 'prod2']);
        $uri2 = "/cart/product/" . $product2->getId() . '/add';

        $clearCartUri = '/cart/clear';

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
                $this->assertNotNull($session->get(CartService::CART_SESSION_KEY));
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
                $cart = $session->get(CartService::CART_SESSION_KEY);
                $this->assertEquals(4, $cart[$product1->getId()]->quantity);
                $this->assertEquals(6, $cart[$product2->getId()]->quantity);
                // Todo: More tests
            })
            // clear cart
            ->visit($clearCartUri)
            ->use(function (\Zenstruck\Browser $browser) {
                $session = $browser->client()->getRequest()->getSession();
                $this->assertNull($session->get(CartService::CART_SESSION_KEY));
                // Todo: More tests
            })
            ->assertSuccessful();

    }
}
