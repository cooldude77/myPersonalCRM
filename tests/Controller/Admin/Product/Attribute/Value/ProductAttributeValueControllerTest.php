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
                'product_attribute_value_create_form[name]', 'Attribute Val 1'
            )
            ->fillField('product_attribute_value_create_form[value]', 'Attribute Value 1')
            ->fillField(
                'product_attribute_value_create_form[productAttributeId]', $attribute->getId())
            ->click('Save')
            ->assertSuccessful();

        $created = ProductAttributeValueFactory::find(array('name' => 'Attribute Val 1'));

        $this->assertEquals('Attribute Val 1', $created->getName());

    }


    public function testEdit()
    {

        $attributeType = ProductAttributeTypeFactory::find(['name' => 'SINGLE_SELECT']);
        $attribute = ProductAttributeFactory::createOne(['productAttributeType' => $attributeType]);
        $attributeValue = ProductAttributeValueFactory::createOne(['productAttribute'=>$attribute]);



        $id = $attributeValue->getId();

        $uri = "/product/attribute/value/{$id}/edit";
        $this->browser()
            ->visit($uri)
            ->fillField(
                'product_attribute_value_edit_form[name]', 'Attribute Val 1'
            )
            ->fillField('product_attribute_value_edit_form[value]', 'Attribute Value 1')
            ->click('Save')
            ->assertSuccessful();

        $created = ProductAttributeValueFactory::find(array('name' => "Attribute Val 1"));

        $this->assertEquals('Attribute Val 1', $created->getName());
    }

    public function testList()
    {

        $attributeType = ProductAttributeTypeFactory::find(['name' => 'SINGLE_SELECT']);
        $attribute = ProductAttributeFactory::createOne(['productAttributeType' => $attributeType]);
        ProductAttributeValueFactory::createOne(['productAttribute'=>$attribute]);

        $id = $attribute->getId();
        $url = "/product/attribute/{$id}/value/list";
        $this->browser()->visit($url)->assertSuccessful();

    }

}