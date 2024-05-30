<?php

namespace App\Tests\Fixtures;

use App\Entity\Category;
use App\Entity\Product;
use App\Factory\CategoryFactory;
use App\Factory\ProductFactory;
use Zenstruck\Foundry\Proxy;

trait ProductFixture
{
    public Category|Proxy $category;

    public Product|Proxy $product;

    function createProductFixtures(): void
    {
        $this->category = CategoryFactory::createOne(['name' => 'Cat', 'description' => 'Category']
        );

        $this->product = ProductFactory::createOne(['category' => $this->category,
                                                    'name' => 'Product',
                                                    'description' => 'A new product',
                                                    'isActive' => true]);
    }

}