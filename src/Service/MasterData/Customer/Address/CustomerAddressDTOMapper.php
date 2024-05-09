<?php

namespace App\Service\MasterData\Customer\Address;

use App\Entity\Customer;
use App\Entity\CustomerAddress;
use App\Form\MasterData\Customer\Address\DTO\CustomerAddressDTO;
use App\Repository\CustomerAddressRepository;
use App\Repository\CustomerRepository;
use App\Repository\PinCodeRepository;

readonly class CustomerAddressDTOMapper
{

    public function __construct(private CustomerRepository $customerRepository,
        private CustomerAddressRepository $customerAddressRepository,
        private PinCodeRepository $pinCodeRepository,
    ) {
    }

    public function mapDtoToEntityForCreate(CustomerAddressDTO $customerAddressDTO): CustomerAddress
    {
        /** @var Customer $customer */

        $customer = $this->customerRepository->findOneBy(
            ['id' => $customerAddressDTO->customerId]
        );

        $customerAddress = $this->customerAddressRepository->create($customer);

        $customerAddress->setLine1($customerAddressDTO->line1);

        $customerAddress->setCustomer($customer);

        $customerAddress->setPinCode(
            $this->pinCodeRepository->findOne(
                $customerAddressDTO->pinCodeId
            )
        );

        return $customerAddress;

    }

    public function mapDtoToEntityForUpdate(CustomerAddressDTO $customerAddressDTO,
        CustomerAddress $customerAddressEntity
    ): CustomerAddress {

        $customerAddressEntity->setLine1($customerAddressDTO->line1);

        return $customerAddressEntity;
    }

}