<?php

namespace App\Tests\Controller\Admin\Product\Attribute;

use App\Entity\ProductAttribute;
use App\Factory\ProductAttributeFactory;
use App\Factory\ProductAttributeTypeFactory;
use App\Factory\ProductTypeFactory;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Browser\Test\HasBrowser;

class ProductAttributeControllerTest extends WebTestCase
{
    use HasBrowser;

    public function testCreate()
    {


        $attributeType = ProductAttributeTypeFactory::find(['name' => 'SINGLE_SELECT']);
        $uri = '/product/attribute/create';
        $this->browser()
            ->visit($uri)
            ->fillField(
                'product_attribute_create_form[name]', 'Attribute 1'
            )
            ->fillField('product_attribute_create_form[description]', 'product_attribute 1')
            ->fillField('product_attribute_create_form[productAttributeTypeId]',
                $attributeType->getId())
            ->click('Save')
            ->assertSuccessful();

        $created = ProductAttributeFactory::find(array('name' => "Attribute 1"));

        $this->assertEquals("Attribute 1", $created->getName());

    }

    public function testEdit()
    {

        $attributeType = ProductAttributeTypeFactory::find(['name' => 'SINGLE_SELECT']);

        $attribute=  ProductAttributeFactory::createOne(['productAttributeType'=>$attributeType]);

        $id = $attribute->getId();

        $uri = "/product/attribute/{$id}/edit";
        $this->browser()
            ->visit($uri)
            ->fillField(
                'product_attribute_edit_form[name]', 'Attribute 1'
            )
            ->fillField('product_attribute_edit_form[description]', 'Attribute Desc 1')
            ->click('Save')
            ->assertSuccessful();

        $created = ProductAttributeFactory::find(array('name' => "Attribute 1"));

        $this->assertEquals('Attribute 1', $created->getName());
    }

    public function testList()
    {

        $url = '/product/attribute/list';
        $this->browser()->visit($url)->assertSuccessful();

    }

}
