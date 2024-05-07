<?php

namespace App\Service\MasterData\Customer\Address;

use App\Entity\Customer;
use App\Entity\CustomerAddress;
use App\Form\MasterData\Customer\Address\DTO\CustomerAddressDTO;
use App\Repository\CustomerRepository;
use App\Repository\CustomerAddressRepository;

readonly class CustomerAddressDTOMapper
{

    public function __construct(private CustomerRepository $customerRepository,
        private CustomerAddressRepository $customerAddressRepository
    ) {
    }

    public function mapDtoToEntityForCreate(CustomerAddressDTO $customerAddressDTO
    ): CustomerAddress {
        /** @var Customer $customer */

        $customer = $this->customerRepository->findOneBy(
            ['id' => $customerAddressDTO->customerId]
        );

        $attribute = $this->customerAddressRepository->create($customer);

        $attribute->setLine($customerAddressDTO->name);
        $attribute->setValue($customerAddressDTO->value);

        $attribute->setCustomer($customer);

        return $attribute;

    }

    public function mapDtoToEntityForUpdate(CustomerAddressDTO $customerAddressDTO,
        CustomerAddress $customerAddressEntity): CustomerAddress
    {

        $customerAddressEntity->setName($customerAddressDTO->name);
        $customerAddressEntity->setValue($customerAddressDTO->value);

        return $customerAddressEntity;
    }

}