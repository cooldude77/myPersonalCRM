<?php

namespace App\Service\Module\WebShop\External\CheckOut;

use App\Service\Module\WebShop\External\Cart\Session\CartSessionService;

class CheckOutService
{

    public function __construct(private readonly CartSessionService $cartService,
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