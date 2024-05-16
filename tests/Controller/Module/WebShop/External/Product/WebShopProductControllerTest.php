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


    /**
     * Requires this test extends Symfony\Bundle\FrameworkBundle\Test\KernelTestCase
     * or Symfony\Bundle\FrameworkBundle\Test\WebTestCase.
     */
    public function testSimpleSession()
    {

        /*
           Example when we don't use client from browser() function, which creates its own
        client and its own session.
         $client = static::createClient();
           $session = $this->createSession($client);

           //  $tokenGenerator = $client->getContainer()->get('security.csrf.token_generator');
           //$token = $this->generateCsrfToken($session, $tokenGenerator, 'expected token id');

           */


        $client = static::createClient();
        $session = $this->createSession($client);

        $client->request('POST', '/locale', [
            'locale' => 'fr_FR',
        ]);

        $this->assertSame('fr_FR', $session->get('locale'));
    }

    public function testAddProductToCartTest()
    {

        $product = ProductFactory::createOne(["name" => 'prod1']);
        $uri = "/web-shop/cart/product/" . $product->getId() . '/add';

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
            ->fillField('web_shop_add_product_single_form[productId]', $product->getId())
            ->fillField(
                'web_shop_add_product_single_form[quantity]', 1
            )
            ->click('Add To Cart')->assertSuccessful();


        // Todo: more validations needed

    }


}
