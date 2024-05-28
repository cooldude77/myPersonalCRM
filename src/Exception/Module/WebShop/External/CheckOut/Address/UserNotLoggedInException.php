<?php

namespace App\Exception\Module\WebShop\External\CheckOut\Address;

use Doctrine\DBAL\Exception;
use Throwable;

class UserNotLoggedInException extends Exception
{

public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
{
    parent::__construct($message, $code, $previous);
}
}