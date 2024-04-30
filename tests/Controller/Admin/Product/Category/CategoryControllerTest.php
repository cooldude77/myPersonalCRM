<?php

namespace App\Tests\Controller\Admin\Product\Category;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Browser\Test\HasBrowser;

class CategoryControllerTest extends WebTestCase
{

    use HasBrowser;

    /**
     * Requires this test extends Symfony\Bundle\FrameworkBundle\Test\KernelTestCase
     * or Symfony\Bundle\FrameworkBundle\Test\WebTestCase.
     */
    public function testCreate()
    {

        $createUrl = '/category/create';
        $this->browser()
            ->visit($createUrl)
            ->fillField(
                'category_create_form[name]', 'Cat1'
            )
            ->fillField('category_create_form[description]', 'Category 1')
            ->fillField('category_create_form[parent]', "")
            ->click('Save')
            ->assertSuccessful();

        // The value of category->getId() will be  1

        $visit = $this->browser()->visit($createUrl);

        $crawler = $visit->client()->getCrawler();

        $domDocument = $crawler->getNode(0)?->parentNode;

        $option = $domDocument->createElement('option');
        $option->setAttribute('value', 1);
        $selectElement = $crawler->filter('select')->getNode(0);
        $selectElement->appendChild($option);

        $visit->fillField('category_create_form[name]', 'Cat2')
            ->fillField(
                'category_create_form[description]', 'Category 2'
            )
            ->fillField('category_create_form[parent]', "1")
            ->click('Save')
            ->assertSuccessful();

    }



    public function testList()
    {

        $url = '/category/list';
        $this->browser()
            ->visit($url)
            ->assertSuccessful();

    }


    }
