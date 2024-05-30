<?php

namespace App\Tests\Fixtures;

use App\Entity\Category;
use App\Entity\Currency;
use App\Entity\PriceProductBase;
use App\Entity\Product;
use App\Factory\CategoryFactory;
use App\Factory\CurrencyFactory;
use App\Factory\PriceProductBaseFactory;
use App\Factory\ProductFactory;
use Zenstruck\Foundry\Proxy;

trait PriceFixture
{
    public Category|Proxy $category;

    public Product|Proxy $product;

    public PriceProductBase|Proxy $price;

    public Currency|Proxy $currency;


    function createPriceFixtures(): void
    {
        $this->category = CategoryFactory::createOne(['name' => 'Cat', 'description' => 'Category']
        );

        $this->product = ProductFactory::createOne(['category' => $this->category,
                                                    'name' => 'Product',
                                                    'description' => 'A new product',
                                                    'isActive' => true]);

        $this->currency=CurrencyFactory::createOne(['code'=>'USD']);


        $this->price = PriceProductBaseFactory::createOne(['product'=>$this->product,
                                                           'currency'=>$this->currency]);

    }

}