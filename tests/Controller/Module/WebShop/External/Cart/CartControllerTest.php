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

        $x = $this->browser()->visit($uri1)
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
            ->visit($cartUri)
            ->use(function (\Zenstruck\Browser $browser) {
                $session = $browser->client()->getRequest()->getSession();
                $this->assertNotNull($session->get(CartService::CART_SESSION_KEY));
                // Todo: More tests
            })
            ->visit($clearCartUri)
            ->use(function (\Zenstruck\Browser $browser) {
                $session = $browser->client()->getRequest()->getSession();
                $this->assertNull($session->get(CartService::CART_SESSION_KEY));
                // Todo: More tests
            })
            ->assertSuccessful();

        $y = 0;

        // Todo: more validations needed


    }
}
