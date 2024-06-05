<?php

namespace App\Service\Module\WebShop\External\CheckOut\Address;

use App\Entity\User;
use Exception;

class UserNotAssociatedWithACustomerException extends Exception
{

    /**
     * @param User $user
     */
    public function __construct(User $user)
    {
        parent::__construct();
    }
}