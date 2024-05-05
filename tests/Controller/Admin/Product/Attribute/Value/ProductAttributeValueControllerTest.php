<?php

namespace App\Tests\Controller\Admin\Product\Attribute\Value;

use App\Factory\ProductAttributeFactory;
use App\Factory\ProductAttributeTypeFactory;
use App\Factory\ProductAttributeValueFactory;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Browser\Test\HasBrowser;

class ProductAttributeValueControllerTest extends WebTestCase
{
    use HasBrowser;

    public function testCreate()
    {

        $attributeType = ProductAttributeTypeFactory::find(['name' => 'SINGLE_SELECT']);

        $attribute = ProductAttributeFactory::createOne(['productAttributeType' => $attributeType]);
        $id = $attribute->getId();

        $uri = "/product/attribute/{$id}/value/create";
        $this->browser()
            ->visit($uri)
            ->fillField(
                'product_attribute_value_create_form[name]', 'Attribute Value 1'
            )
            ->fillField('product_attribute_value_create_form[description]', 'Attribute Value 1')
            ->fillField(
                'product_attribute_value_create_form[productAttributeId]', $attribute->getId())
            ->click('Save')
            ->assertSuccessful();

        $created = ProductAttributeValueFactory::find(array('name' => "Attribute Value 1"));

        $this->assertEquals("Attribute Value 1", $created->getName());

    }


    public function testUpdate()
    {

        $attributeType = ProductAttributeTypeFactory::find(['name' => 'SINGLE_SELECT']);
        $attribute = ProductAttributeFactory::createOne(['productAttributeType' => $attributeType]);
        $attributeValue = ProductAttributeValueFactory::createOne(['productAttribute'=>$attribute]);



        $id = $attributeValue->getId();

        $uri = "/product/attribute/value/{$id}/edit";
        $this->browser()
            ->visit($uri)
            ->fillField(
                'product_attribute_value_edit_form[name]', 'Attribute Value 1'
            )
            ->fillField('product_attribute_value_edit_form[value]', 'Attribute Value Description 1')
            ->click('Save')
            ->assertSuccessful();

        $created = ProductAttributeFactory::find(array('name' => "Attribute Value 1"));

        $this->assertEquals("Attribute Value 1", $created->getName());
    }

    public function testList()
    {

        $attributeType = ProductAttributeTypeFactory::find(['name' => 'SINGLE_SELECT']);
        $attribute = ProductAttributeFactory::createOne(['productAttributeType' => $attributeType]);
        $attributeValue = ProductAttributeValueFactory::createOne(['productAttribute'=>$attribute]);

        $id = $attribute->getId();
        $url = "/product/attribute/{$id}/value/list";
        $this->browser()->visit($url)->assertSuccessful();

    }

}