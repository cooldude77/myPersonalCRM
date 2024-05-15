<?php

namespace App\Service\Module\WebShop\Object;

class CartObject
{

    public function __construct(public string $productId, public int $quantity = 0)
    {
    }


    public function increaseQuantityBy(int $increaseBy = 1): void
    {
        //todo: check max quantity
        $this->quantity+=$increaseBy;

    }
    public function decreaseQuantityBy(int $decreaseBy = 1): void
    {
        //todo: check quantity 0;
        $this->quantity-=$decreaseBy;

    }

}