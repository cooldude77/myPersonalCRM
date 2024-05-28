<?php

namespace App\Form\Module\WebShop\External\Address\DTO;

use App\Form\MasterData\Customer\Address\DTO\CustomerAddressDTO;

/**
 * For using the form when there are multiple billing/shipping addresses
 */
class AddressChooseDTO
{
    public ?string $address = null;
    public bool $isChosen = false;
}