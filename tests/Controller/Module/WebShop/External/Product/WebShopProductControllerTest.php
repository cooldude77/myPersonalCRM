<?php

namespace App\Tests\Controller\Module\WebShop\External\Product;

use App\Factory\ProductFactory;
use App\Service\Testing\SessionHelper;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Browser\Test\HasBrowser;

class WebShopProductControllerTest extends WebTestCase
{
    use HasBrowser;
    use SessionHelper;

    public function testAddProductToCartTest()
    {

        $product = ProductFactory::createOne(["name" => 'prod1']);
        $uri = "/cart/product/" . $product->getId() . '/add';

        /*
           Example when we don't use client from browser() function, which creates its own
        client and its own session.
         $client = static::createClient();
           $session = $this->createSession($client);

           //  $tokenGenerator = $client->getContainer()->get('security.csrf.token_generator');
           //$token = $this->generateCsrfToken($session, $tokenGenerator, 'expected token id');

           */

        /*
          In case we want to add a cookie
         ->use(
            function (CookieJar $cookieJar) {
                $sessionCookie = new Cookie(
                    "abcd",
                    "pqrs",
                    null,
                    null,
                    'localhost',
                );
                $cookieJar->set($sessionCookie);

            }
        )
        visit() function uses request() function
         */

        $browser = $this->browser()->visit($uri)
            ->fillField('cart_add_product_single_form[productId]', $product->getId())
            ->fillField(
                'cart_add_product_single_form[quantity]', 1
            )
            ->click('Add To Cart')->assertSuccessful();


        // Todo: more validations needed

    }


}
