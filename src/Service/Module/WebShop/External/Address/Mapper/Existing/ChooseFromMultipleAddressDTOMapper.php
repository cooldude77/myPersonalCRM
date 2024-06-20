<?php

namespace App\Service\Module\WebShop\External\Address\Mapper\Existing;

use App\Entity\CustomerAddress;
use App\Form\Module\WebShop\External\Address\Existing\DTO\AddressChooseExistingSingleDTO;
use App\Service\MasterData\Customer\Address\CustomerAddressQuery;

readonly class ChooseFromMultipleAddressDTOMapper
{

    public function __construct(private CustomerAddressQuery $customerAddressQuery)
    {
    }

    public function mapAddressesToDto(array $addresses): array
    {

        $array = [];

        /** @var CustomerAddress $address */
        foreach ($addresses as $address){
            $dto = new AddressChooseExistingSingleDTO();

            $dto->isChosen = false;
            $dto->address = $this->customerAddressQuery->getAddressInASingleLine($address->getId());

            $array[]=$dto;


        }
        return $array;
    }
}