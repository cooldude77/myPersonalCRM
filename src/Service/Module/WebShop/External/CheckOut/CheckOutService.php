<?php

namespace App\Service\Module\WebShop\External\CheckOut;

use App\Service\Module\WebShop\External\Cart\CartService;

class CheckOutService
{

    public function __construct(private readonly CartService $cartService,
    private  readonly  CheckOutAddressService $checkOutAddressService)
    {
    }

    public function isEverythingOkay():bool
    {
        $ok = !empty($this->cartService->getCartArray());

        $ok = $ok & $this->checkOutAddressService->areAddressesProper();

        // todo:

        return true;
    }
}