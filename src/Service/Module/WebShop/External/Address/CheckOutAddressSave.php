<?php

namespace App\Service\Module\WebShop\External\Address;

use App\Entity\CustomerAddress;
use App\Service\MasterData\Customer\Address\CustomerAddressSave;

readonly class CheckOutAddressSave
{

    public function __construct(
        private CustomerAddressSave $customerAddressSave
    ) {

    }


    public function save(CustomerAddress $customerAddress): void
    {

        $this->customerAddressSave->save($customerAddress);

    }

}