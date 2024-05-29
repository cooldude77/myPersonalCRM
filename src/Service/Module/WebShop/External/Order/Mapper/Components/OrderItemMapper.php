<?php

namespace App\Service\Module\WebShop\External\Order\Mapper\Components;

use App\Entity\OrderHeader;
use App\Repository\OrderItemRepository;
use App\Repository\ProductRepository;
use App\Service\Module\WebShop\External\Cart\Session\CartSessionService;
use Doctrine\Common\Collections\ArrayCollection;

class OrderItemMapper
{
    public function __construct(private readonly CartSessionService $cartSessionService,
        private readonly OrderItemRepository $orderItemRepository,
        private readonly ProductRepository $productRepository,
        private readonly ProductService $productService
    ) {
    }

    public function map(OrderHeader $orderHeader): array
    {

        $orderItems =[];

        foreach ($this->cartSessionService->getCartArray() as $item) {

            $orderItem = $this->orderItemRepository->create($orderHeader);

            $orderItem->setQuantity($item->quantity);

            $product = $this->productRepository->find($item->productId);

            $orderItem->setProduct($product);

            // todo
            $orderItem->setSnapShot($this->productService->snapShot($product));

            $orderItem->add($item);

            $orderItems[] = $orderItem;
        }
        return $orderItems;
    }
}