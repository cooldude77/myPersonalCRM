<?php

namespace App\Tests\Fixtures;

use App\Entity\City;
use App\Entity\Country;
use App\Entity\PinCode;
use App\Entity\State;
use App\Factory\CityFactory;
use App\Factory\CountryFactory;
use App\Factory\PinCodeFactory;
use App\Factory\StateFactory;
use Zenstruck\Foundry\Proxy;

trait LocationFixture
{
    public Country|Proxy $country;
    public State|Proxy $state;
    public City|Proxy $city;
    public PinCode|Proxy $pinCode;

    function createLocationFixtures(): void
    {

        $this->country = CountryFactory::createOne();

        $this->state = StateFactory::createOne(['country' => $this->country]);
        $this->city = CityFactory::createOne(['state' => $this->state]);
        $this->pinCode = PinCodeFactory::createOne(['city' => $this->city]);

    }
}