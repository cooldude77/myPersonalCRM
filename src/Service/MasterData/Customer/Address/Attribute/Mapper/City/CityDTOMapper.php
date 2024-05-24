<?php

namespace App\Service\MasterData\Customer\Address\Attribute\Mapper\City;

use App\Entity\City;
use App\Form\MasterData\Customer\Address\Attribute\City\DTO\CityDTO;

class CityDTOMapper
{

    public function mapToEntityForCreate(CityDTO $cityDTO): City
    {
        $city = new City();
        return $city;
    }

    public function mapToEntityForEdit(CityDTO $cityDTO): City
    {
        $city = new City();
        return $city;
    }
}