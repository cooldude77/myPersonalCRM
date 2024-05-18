<?php

namespace App\Tests\Controller\MasterData\Inventory;

use App\Factory\InventoryProductFactory;
use App\Factory\ProductFactory;
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
        $product = ProductFactory::createOne();
        $id = $product->getId();

        $createUrl = "/inventory/product/{$id}/create";

        $this->browser()->visit($createUrl)
            ->fillField('inventory_product_create_form[quantity]', 1)
            ->click('Save')
            ->assertSuccessful();

        $created = InventoryProductFactory::find(array('product' => $product));

        $this->assertEquals(1, $created->getQuantity());


    }

    /**
     * Requires this test extends Symfony\Bundle\FrameworkBundle\Test\KernelTestCase
     * or Symfony\Bundle\FrameworkBundle\Test\WebTestCase.
     */
    public function testEdit()
    {
        $inventoryProduct = InventoryProductFactory::createOne();

        $id = $inventoryProduct->getId();

        $url = "/inventory/$id/edit";

        $visit = $this->browser()->visit($url)
            ->fillField('inventory_product_edit_form[quantity]', 10)
            ->click('Save')
            ->assertSuccessful();


        $created = InventoryProductFactory::find(array('id' => $id));

        $this->assertEquals(10, $created->getQuantity());


    }

    /**
     * Requires this test extends Symfony\Bundle\FrameworkBundle\Test\KernelTestCase
     * or Symfony\Bundle\FrameworkBundle\Test\WebTestCase.
     */
    public function testDisplay()
    {

        $inventoryProduct = InventoryProductFactory::createOne();

        $id = $inventoryProduct->getId();
        $createUrl = "/inventory/$id/display";

        $this->browser()->visit($createUrl)->assertSuccessful();

    }

    public function testList()
    {
        $url = '/inventory/list';
        $this->browser()->visit($url)->assertSuccessful();

    }


}
