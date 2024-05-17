<?php

namespace App\Tests\Controller\Module\WebShop\External\Cart;

use App\Factory\ProductFactory;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Browser\Test\HasBrowser;

class CartControllerTest extends WebTestCase
{
    use HasBrowser;

    public function testCart()
    {

        $product1 = ProductFactory::createOne(["name" => 'prod1']);
        $uri1 = "/web-shop/cart/product/" . $product1->getId() . '/add';

        $this->browser()->visit($uri1)
            ->fillField('web_shop_add_product_single_form[productId]', $product1->getId())
            ->fillField(
                'web_shop_add_product_single_form[quantity]', 1
            )
            ->click('Add To Cart')->assertSuccessful();

        $product2 = ProductFactory::createOne(["name" => 'prod2']);
        $uri2 = "/web-shop/cart/product/" . $product2->getId() . '/add';

        $this->browser()->visit($uri2)
            ->fillField('web_shop_add_product_single_form[productId]', $product2->getId())
            ->fillField(
                'web_shop_add_product_single_form[quantity]', 2
            )
            ->click('Add To Cart')->assertSuccessful();


        $cartUri = '/cart';

        $this->browser()->visit($cartUri)
            ->assertSuccessful();


        // Todo: more validations needed


    }
}
