<?php

namespace App\Tests\Controller\Admin\UI;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Browser\Test\HasBrowser;

class PanelMainControllerTest extends WebTestCase
{
    use HasBrowser;

    public function testAdmin()
    {
        $uri = '/admin';
        $this->browser()->visit($uri)->assertSuccessful();

        $this->browser()
            ->visit($uri)
            ->click('a#sidebar-link-category-list')
            ->followRedirects()
            ->assertSuccessful();

        $this->browser()
            ->visit($uri)
            ->click('a#sidebar-link-product-list')
            ->followRedirects()
            ->assertSuccessful();

        $this->browser()
            ->visit($uri)
            ->click('a#sidebar-link-product-type-list')
            ->followRedirects()
            ->assertSuccessful();

        $this->browser()
            ->visit($uri)
            ->click('a#sidebar-link-product-attribute-list')
            ->followRedirects()
            ->assertSuccessful();

     $this->browser()
            ->visit($uri)
            ->click('a#sidebar-link-customer-list')
            ->followRedirects()
            ->assertSuccessful();


        /*
                $crawler = $this->browser()->visit($uri)->crawler();
                $link = $crawler->selectLink('Categories')->link();

                $client = $this->browser()->client();
                $client->click($link);
                $client->followRedirects(true);
                $this->assertEquals(200, $client->getResponse()->getStatusCode());

                $this->browser()->fillField(
                    'category_create_form[name]', 'Cat1'
                )->fillField('category_create_form[description]', 'Category 1')->fillField(
                        'category_create_form[parent]', ""
                    )->click('Save')->assertSuccessful();
          */
    }
}
