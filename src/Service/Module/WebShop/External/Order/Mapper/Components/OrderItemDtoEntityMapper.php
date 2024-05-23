<?php

namespace App\Service\Module\WebShop\External\Order\Mapper\Components;

use App\Form\Module\WebShop\External\Order\DTO\Components\Components\OrderItemDTO;
use Doctrine\Common\Collections\ArrayCollection;

class OrderItemDtoEntityMapper
{
    public function map()
    {

        $orderItems = new ArrayCollection();
        /** @var OrderItemDTO $item */
        foreach ($orderObjectDTO->orderItemDTOArray as $item) {

            $orderItem = $this->orderItemRepository->create($orderHeader);

            $orderItem->setQuantity($item->quantity);

            $product = $this->productRepository->find($item->productId);
            $orderItem->setProduct($product);

            $orderItems->add($item);
        }
    }
}