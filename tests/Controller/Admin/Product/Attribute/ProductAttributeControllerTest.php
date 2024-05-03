<?php

namespace App\Tests\Controller\Admin\Product\Attribute;

use App\Factory\ProductAttributeFactory;
use App\Factory\ProductAttributeTypeFactory;
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
}
