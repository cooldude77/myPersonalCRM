<?php

namespace App\Event\Module\WebShop\External\Payment;

use App\Entity\Customer;
use Symfony\Contracts\EventDispatcher\Event;

class PaymentEvent extends Event
{

    public function __construct(private readonly mixed $paymentData =null)
    {
    }

    public function getPaymentData(): mixed
    {
        return $this->paymentData;
    }


}