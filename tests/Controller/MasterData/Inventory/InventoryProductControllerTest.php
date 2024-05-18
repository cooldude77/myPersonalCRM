<?php

namespace App\Tests\Controller\MasterData\Inventory;

use App\Factory\CategoryFactory;
use App\Factory\InventoryProductFactory;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Browser\Test\HasBrowser;

class InventoryProductControllerTest extends WebTestCase
{

    use HasBrowser;

    /**
     * Requires this test extends Symfony\Bundle\FrameworkBundle\Test\KernelTestCase
     * or Symfony\Bundle\FrameworkBundle\Test\WebTestCase.
     */
    public function testCreate()
    {
        $category = CategoryFactory::createOne(['name' => 'Cat1',
                                                'description' => 'Category 1']);

        $id = $category->getId();
        $createUrl = '/inventoryProduct/create';

        $visit = $this->browser()->visit($createUrl);

        $crawler = $visit->client()->getCrawler();

        $domDocument = $crawler->getNode(0)?->parentNode;

        $option = $domDocument->createElement('option');
        $option->setAttribute('value', $category->getId());
        $selectElement = $crawler->filter('select')->getNode(0);
        $selectElement->appendChild($option);

        $visit->fillField('inventoryProduct_create_form[name]', 'Prod1')->fillField(
                'inventoryProduct_create_form[description]', 'InventoryProduct 1'
            )->fillField('inventoryProduct_create_form[category]', $id)->click('Save')->assertSuccessful();

        $created = InventoryProductFactory::find(array('name' => "Prod1"));

        $this->assertEquals("Prod1", $created->getName());


    }

    /**
     * Requires this test extends Symfony\Bundle\FrameworkBundle\Test\KernelTestCase
     * or Symfony\Bundle\FrameworkBundle\Test\WebTestCase.
     */
    public function testEdit()
    {
        $category1 = CategoryFactory::createOne(['name' => 'Cat1',
                                                 'description' => 'Category 1']);

        $category2 = CategoryFactory::createOne(['name' => 'Cat2',
                                                 'description' => 'Category 2']);


        $inventoryProduct = InventoryProductFactory::createOne(['category' => $category1]);

        $id = $inventoryProduct->getId();

        $url = "/inventoryProduct/$id/edit";

        $visit = $this->browser()->visit($url);

        $crawler = $visit->client()->getCrawler();

        $domDocument = $crawler->getNode(0)?->parentNode;

        $option = $domDocument->createElement('option');
        $option->setAttribute('value', $category1->getId());
        $selectElement = $crawler->filter('select')->getNode(0);
        $selectElement->appendChild($option);

        $option = $domDocument->createElement('option');
        $option->setAttribute('value', $category2->getId());
        $selectElement = $crawler->filter('select')->getNode(0);
        $selectElement->appendChild($option);

        $visit->fillField('inventoryProduct_edit_form[name]', 'Prod1')
            ->fillField(
                'inventoryProduct_edit_form[description]', 'InventoryProduct 1'
            )
            ->fillField('inventoryProduct_edit_form[category]', $category2->getId())
            ->click('Save')
            ->assertSuccessful();

        $created = InventoryProductFactory::find(array('name' => "Prod1"));

        $this->assertEquals("Prod1", $created->getName());


    }

    /**
     * Requires this test extends Symfony\Bundle\FrameworkBundle\Test\KernelTestCase
     * or Symfony\Bundle\FrameworkBundle\Test\WebTestCase.
     */
    public function testDisplay()
    {
        $category = CategoryFactory::createOne(['name' => 'Cat1',
                                                'description' => 'Category 1']);


        $inventoryProduct = InventoryProductFactory::createOne(['category' => $category]);

        $id = $inventoryProduct->getId();
        $createUrl = "/inventoryProduct/$id/display";

        $this->browser()->visit($createUrl)->assertSuccessful();


    }


    public function testList()
    {

        $url = '/inventoryProduct/list';
        $this->browser()->visit($url)->assertSuccessful();

    }


}
