<?php

namespace App\Service\Module\WebShop\External\CheckOut\Address;

use App\Entity\CustomerAddress;
use App\Form\MasterData\Customer\Address\DTO\CustomerAddressDTO;
use App\Form\MasterData\Customer\DTO\CustomerDTO;
use App\Service\MasterData\Customer\Address\CustomerAddressDTOMapper;

class CustomerService
{
    public function __construct(
        private readonly DatabaseOperations $databaseOperations,
        private readonly CustomerAddressDTOMapper $customerAddressDTOMapper
    ) {
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