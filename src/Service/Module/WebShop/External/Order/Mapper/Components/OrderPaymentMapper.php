<?php

namespace App\Service\Module\WebShop\External\Order\Mapper\Components;

use App\Entity\OrderHeader;
use App\Entity\OrderPayment;
use App\Repository\OrderPaymentRepository;
use App\Service\Module\WebShop\External\Payment\PaymentService;

class OrderPaymentMapper
{
    public function __construct(private  readonly PaymentService $paymentService,
    private  readonly OrderPaymentRepository $orderPaymentRepository)
    {
    }

    public function map(OrderHeader $orderHeader,PaymentObject $paymentObject): OrderPayment
    {

        $orderPayment = $this->orderPaymentRepository->create($orderHeader);

        $orderPayment->setPaymentData($paymentObject->getPaymentData());
        $orderPayment->setSnapShopt($paymentObject->getSnapShot());


    }
}