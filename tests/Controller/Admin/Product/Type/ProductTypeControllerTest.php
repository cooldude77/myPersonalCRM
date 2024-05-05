<?php

namespace App\Tests\Controller\Admin\Product\Type;

use App\Factory\ProductTypeFactory;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Browser\Test\HasBrowser;

class ProductTypeControllerTest extends WebTestCase
{
    use HasBrowser;

    public function testCreate()
    {

        $uri = '/product/type/create';
        $this->browser()
            ->visit($uri)
            ->fillField(
                'product_type_create_form[name]', 'Type 1'
            )
            ->fillField('product_type_create_form[value]', 'product_type 1')
            ->click('Save')
            ->assertSuccessful();

        $created = ProductTypeFactory::find(array('name' => "Type 1"));

        $this->assertEquals("Type 1", $created->getName());
    }


    public function testUpdate()
    {

        $type = ProductTypeFactory::createOne(['name'=>'Type 1',
        'description'=>'product_type 1']);
        $id = $type->getId();

        $uri = "/product/type/{$id}/edit";
        $this->browser()
            ->visit($uri)
            ->fillField(
                'product_type_edit_form[name]', 'Type 1'
            )
            ->fillField('product_type_edit_form[value]', 'product_type 1')
            ->click('Save')
            ->assertSuccessful();

        $created = ProductTypeFactory::find(array('name' => "Type 1"));

        $this->assertEquals("Type 1", $created->getName());
    }

    public function testList()
    {

        $url = '/product/type/list';
        $this->browser()->visit($url)->assertSuccessful();

    }
}
