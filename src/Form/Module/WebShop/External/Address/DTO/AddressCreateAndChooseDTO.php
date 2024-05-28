<?php

namespace App\Form\Module\WebShop\External\Address\DTO;

use App\Form\MasterData\Customer\Address\DTO\CustomerAddressDTO;

class AddressCreateAndChooseDTO
{

    public CustomerAddressDTO $address;
    public bool $isChosen = false;

    public function __construct()
    {
        $this->address = new CustomerAddressDTO();
    }
}