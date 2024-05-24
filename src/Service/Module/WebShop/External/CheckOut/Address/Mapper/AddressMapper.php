<?php

namespace App\Service\Module\WebShop\External\CheckOut\Address\Mapper;

use App\Entity\Address;
use App\Form\Module\WebShop\External\CheckOut\Address\AddressMultiple;
use App\Form\Module\WebShop\External\CheckOut\Address\DTO\AddressDTO;

class AddressMapper
{


    public function mapEntityToDto($billingAddresses = [], $shippingAddresses = []): array
    {

        $dtoArray = [];


        if (!empty($billingAddresses)) {
            /** @var Address $address */
            foreach ($billingAddresses as $address) {
                $dto = new AddressDTO();
                $dto->id = $address->getId();

                $dtoArray[AddressMultiple::BILLING][] = $dto;
            }
        }

        if (!empty($shippingAddresses)) {
            /** @var Address $address */
            foreach ($shippingAddresses as $address) {
                $dto = new AddressDTO();
                $dto->id = $address->getId();

                $dtoArray[AddressMultiple::SHIPPING][] = $dto;
            }
        }

        return $dtoArray;
    }
}