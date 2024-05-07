<?php

namespace App\Form\MasterData\Customer\Address\DTO;

use App\Form\MasterData\Address\DTO\AddressDTO;

/**
 * Note: We cannot completely create a DTO is not having a domain object
 * because Entity Type will not create a dropdown if we use just an int
 */
class CustomerAddressDTO
{
    public int $id = 0;
    public int $customerId=0;
   public AddressDTO $addressDTO;

   public function __construct()
   {
       $this->addressDTO = new AddressDTO();
   }

}