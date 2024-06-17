<?php

namespace App\Service\MasterData\Customer\Address;

use App\Entity\CustomerAddress;
use App\Form\MasterData\Customer\Address\DTO\CustomerAddressDTO;
use App\Repository\CustomerAddressRepository;
use App\Service\Component\Database\DatabaseOperations;

class CustomerAddressService
{

    public function __construct(
        private readonly CustomerAddressRepository $customerAddressRepository,
        private readonly CustomerAddressDTOMapper $customerAddressDTOMapper,
        private readonly DatabaseOperations $databaseOperations
    ) {
    }

    public function getAddressInASingleLine(int $id): string
    {
        $customerAddress = $this->customerAddressRepository->find($id);
        return $customerAddress->getLine1() . "\n"
            . ($customerAddress->getLine2() != null ? $customerAddress->getLine2() . "\n" : "")
            . ($customerAddress->getLine3() != null ? $customerAddress->getLine3() . "\n" : "")
            . $customerAddress->getPinCode()->getCity()->getName() . "\n"
            . $customerAddress->getPinCode()->getCity()->getState()->getName() . "\n"
            . $customerAddress->getPinCode()->getCity()->getState()->getCountry()->getName() . "\n"
            . $customerAddress->getPinCode()->getPinCode() . "\n";


    }

    public function mapAndPersist(CustomerAddressDTO $customerAddressDTO): CustomerAddress
    {

        $customerAddress = $this->customerAddressDTOMapper->mapDtoToEntityForCreate(
            $customerAddressDTO
        );
        $this->databaseOperations->persist($customerAddress);
        return $customerAddress;
    }
    public function flush(): void
    {
        $this->databaseOperations->flush();
    }


}