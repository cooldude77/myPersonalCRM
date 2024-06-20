<?php

namespace App\Service\Module\WebShop\External\Address;

use App\Entity\CustomerAddress;
use App\Form\Module\WebShop\External\Address\Existing\DTO\AddressChooseExistingSingleDTO;
use App\Service\MasterData\Customer\Address\CustomerAddressSave;

class AddressChooseMapper
{

    public function __construct(private  readonly  CustomerAddressSave $customerAddressService)
    {
    }

    public function mapAddressesToDto(array $addresses)
    {

        $array = [];

        /** @var CustomerAddress $address */
        foreach ($addresses as $address){
            $dto = new AddressChooseExistingSingleDTO();

            $dto->isChosen = false;
            $dto->address = $this->customerAddressService->getAddressInASingleLine($address->getId());

            $array[]=$dto;


        }
        return $array;
    }
}