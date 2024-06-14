<?php

namespace App\EventSubscriber\Module\WebShop\External\Order;

use App\Event\Module\WebShop\External\Cart\CartEvent;
use App\Event\Module\WebShop\External\Cart\CartEventTypes;
use App\Service\Module\WebShop\External\Cart\Session\CartSessionProductService;
use App\Service\Module\WebShop\External\Order\CartOrderSync;
use App\Service\Module\WebShop\External\Order\OrderRead;
use App\Service\Module\WebShop\External\Order\OrderSave;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

readonly class OrderCartEventSubscriber implements EventSubscriberInterface
{
    public function __construct(private OrderSave $orderSave,
        private readonly OrderRead $orderRead,
        private readonly CartSessionProductService $cartSessionProductService,
        private readonly CartOrderSync $cartOrderSync
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            CartEventTypes::POST_CART_INITIALIZED => 'postCartInitialized',
        ];

    }

    public function postCartInitialized(CartEvent $event): void
    {
        if ($this->cartSessionProductService->isCartEmpty()) {
            if ($this->orderRead->isOpenOrder()) {
                $this->cartOrderSync->copyProductsFromOrderToCart();
            } else {
                $this->orderSave->createNewOrderFromCart($event->getCustomer());
            }
        }

    }
}