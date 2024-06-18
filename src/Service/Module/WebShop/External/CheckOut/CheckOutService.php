<?php

namespace App\Service\Module\WebShop\External\CheckOut;

use App\Controller\Module\WebShop\External\Address\CheckOutAddressService;
use App\Service\Module\WebShop\External\Cart\Session\CartSessionProductService;

class CheckOutService
{


    public function __construct(private readonly CartSessionProductService $cartService,
        private readonly CheckOutAddressService $checkOutAddressService
    ) {
    }

    public function isEverythingOkay(): bool
    {
        $ok = !empty($this->cartService->getCartArray());

        $ok = $ok & $this->checkOutAddressService->areAddressesProper();

        // todo:

        return $ok;
    }


}