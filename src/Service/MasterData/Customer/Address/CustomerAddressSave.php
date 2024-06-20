<?php

namespace App\Service\MasterData\Customer\Address;

use App\Entity\CustomerAddress;
use App\Service\Component\Database\DatabaseOperations;

class CustomerAddressSave
{

    public function __construct(private readonly DatabaseOperations $databaseOperations)
    {
    }

    public function mapAndPersist(CustomerAddress $customerAddress): CustomerAddress
    {

        $this->databaseOperations->persist($customerAddress);
        return $customerAddress;
    }

    public function flush(): void
    {
        $this->databaseOperations->flush();
    }


}