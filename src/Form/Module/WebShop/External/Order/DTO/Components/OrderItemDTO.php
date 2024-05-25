<?php

namespace App\Form\Module\WebShop\External\Order\DTO\Components;

class OrderItemDTO
{

    private ?int $id = 0;

    private ?int $orderHeaderId = 0;

    public ?int $productId = 0;

    public ?int $quantity = 0;

}