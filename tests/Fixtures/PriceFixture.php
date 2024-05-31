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

    public PriceProductBase|Proxy $price;

    function createPriceFixtures(Proxy|Product $product,Proxy|Currency $currency): void
    {

        $this->price = PriceProductBaseFactory::createOne(['product'=>$product,
                                                           'currency'=>$currency]);

    }

}