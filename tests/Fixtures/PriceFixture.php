<?php

namespace App\Tests\Fixtures;

use App\Entity\Currency;
use App\Entity\PriceProductBase;
use App\Entity\Product;
use App\Factory\PriceProductBaseFactory;
use Zenstruck\Foundry\Proxy;

trait PriceFixture
{

    public PriceProductBase|Proxy $priceProductBaseA;
    public PriceProductBase|Proxy $priceProductBaseB;

    public float $priceOfProductA = 100;
    public float $priceOfProductB = 200;

    function createPriceFixtures(Proxy|Product $productA, Proxy|Product $productB,
        Proxy|Currency $currency
    ): void {

        $this->priceProductBaseA = PriceProductBaseFactory::createOne(['product' => $productA,
                                                                       'currency' => $currency,
                                                                       'price' => $this->priceOfProductA]
        );
        $this->priceProductBaseB = PriceProductBaseFactory::createOne(['product' => $productB,
                                                                       'currency' => $currency,
                                                                       'price' => $this->priceOfProductB]
        );

    }

}