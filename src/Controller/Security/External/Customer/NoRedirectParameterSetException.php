<?php

namespace App\Controller\Security\External\Customer;

use Throwable;

class NoRedirectParameterSetException extends \Exception
{
public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
{
    parent::__construct($message, $code, $previous);
}
}