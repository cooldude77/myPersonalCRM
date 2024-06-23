<?php

namespace App\EventSubscriber\Module\WebShop\External\Order;

use App\Event\Module\WebShop\External\Address\CheckoutAddressCreatedEvent;
use App\Event\Module\WebShop\External\Address\Types\CheckoutAddressEventTypes;
use App\Service\Module\WebShop\External\Address\CheckOutAddressSession;
use App\Service\Module\WebShop\External\Order\OrderRead;
use App\Service\Module\WebShop\External\Order\OrderSave;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

readonly class OnCheckoutAddressChosen implements EventSubscriberInterface
{
    public function __construct(private OrderRead $orderRead,
        private OrderSave $orderSave
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            CheckoutAddressEventTypes::POST_ADDRESS_CHOSEN => 'onAddressChosen'
        ];

    }

    public function onAddressChosen(CheckoutAddressCreatedEvent $event): void
    {

        $customer = $event->getCustomer();

        $orderHeader = $this->orderRead->getOpenOrder($customer);

        $address = $event->getCustomerAddress();

        $listAddresses = $this->orderRead->getAddresses($orderHeader);

        $this->orderSave->createOrUpdate($orderHeader, $address,$listAddresses);

    }
}