<?php

namespace App\Tests\Controller\Admin\Product\Product;

use App\Factory\CategoryFactory;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Browser\Test\HasBrowser;

class ProductControllerTest extends WebTestCase
{

    use HasBrowser;

    /**
     * Requires this test extends Symfony\Bundle\FrameworkBundle\Test\KernelTestCase
     * or Symfony\Bundle\FrameworkBundle\Test\WebTestCase.
     */
    public function testCreate()
    {
        $category = CategoryFactory::createOne(['name'=>'Cat1',
                                                'description'=>'Category 1']);
        $createUrl = '/product/create';

        $visit = $this->browser()->visit($createUrl);

        $crawler = $visit->client()->getCrawler();

        $domDocument = $crawler->getNode(0)?->parentNode;

        $option = $domDocument->createElement('option');
        $option->setAttribute('value', $category->getId());
        $selectElement = $crawler->filter('select')->getNode(0);
        $selectElement->appendChild($option);

        $visit->fillField('product_create_form[name]', 'Product 1')
            ->fillField(
                'product_create_form[description]', 'Product 1'
            )
            ->fillField('product_create_form[category]', $category->getId())
            ->click('Save')
            ->assertSuccessful();



        // The value of product->getId() will be  1
/*
        $visit = $this->browser()->visit($createUrl);

        $crawler = $visit->client()->getCrawler();

        $domDocument = $crawler->getNode(0)?->parentNode;

        $option = $domDocument->createElement('option');
        $option->setAttribute('value', 1);
        $selectElement = $crawler->filter('select')->getNode(0);
        $selectElement->appendChild($option);

        $visit->fillField('product_create_form[name]', 'Cat2')
            ->fillField(
                'product_create_form[description]', 'product 2'
            )
            ->fillField('product_create_form[parent]', "1")
            ->click('Save')
            ->assertSuccessful();
*/
    }

/*
    public function testList()
    {

        $url = '/product/list';
        $this->browser()->visit($url)->assertSuccessful();

    }
*/

}
