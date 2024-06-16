<?php

namespace App\EventSubscriber\Module\WebShop\External\Order;

use App\Service\Module\WebShop\External\CheckOut\Address\CustomerFromUserFinder;
use App\Service\Module\WebShop\External\Order\OrderRead;
use App\Service\Module\WebShop\External\Order\OrderToCart;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Http\Event\LoginSuccessEvent;

readonly class OrderCartSyncOnLoginSuccessEventSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly OrderRead $orderRead,
        private readonly OrderToCart $orderToCart,
        private readonly CustomerFromUserFinder $customerFromUserFinder
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            LoginSuccessEvent::class => 'onLoginSuccess'
        ];

    }

    public function onLoginSuccess(LoginSuccessEvent $event): void
    {

        $customer = $this->customerFromUserFinder->getLoggedInCustomer();
        if ($this->orderRead->isOpenOrder($customer)
        ) {  // todo handle exceptions
            $order = $this->orderRead->getOpenOrder($customer);
            $items = $this->orderRead->getOpenOrderItems($order);
            if (count($items) > 0) {
                $this->orderToCart->copyProductsFromOrderToCart($items);
            }

        }
    }
}