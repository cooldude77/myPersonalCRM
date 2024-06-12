<?php

namespace App\EventSubscriber\Module\WebShop\External\Order;

use App\Event\Module\WebShop\External\Cart\CartEventTypes;
use App\Service\Module\WebShop\External\Order\OrderSave;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

readonly class OrderCartEventSubscriber implements EventSubscriberInterface
{
    public function __construct(private OrderSave $orderSave)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            CartEventTypes::POST_CART_INITIALIZED => 'postCartInitialized',
        ];

    }

    public function postCartInitialized(): void
    {
        $this->orderSave->initializeFromCartAndSave();
    }
}