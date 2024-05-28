<?php

namespace App\Controller\Module\WebShop\External\CheckOut\Address;

use App\Entity\CustomerAddress;
use App\Form\Module\WebShop\External\Address\DTO\AddressChooseDTO;
use App\Service\MasterData\Customer\Address\CustomerAddressService;

class AddressChooseMapper
{

    public function __construct(private  readonly  CustomerAddressService $customerAddressService)
    {
    }

    public function mapAddressesToDto(array $addresses)
    {

        $array = [];

        /** @var CustomerAddress $address */
        foreach ($addresses as $address){
            $dto = new AddressChooseDTO();

            $dto->isChosen = false;
            $dto->address = $this->customerAddressService->getAddressInASingleLine($address->getId());

            $array[]=$dto;


        }
        return $array;
    }
}