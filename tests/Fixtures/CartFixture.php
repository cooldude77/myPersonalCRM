<?php

namespace App\Tests\Fixtures;

use App\Entity\Product;
use App\Service\Module\WebShop\External\Cart\Session\CartSessionProductService;
use App\Service\Module\WebShop\External\Cart\Session\Object\CartSessionObject;
use Symfony\Component\HttpFoundation\Session\Session;
use Zenstruck\Foundry\Proxy;

trait CartFixture
{
    private function createCartInSession(Session $session, Proxy|Product $product): void
    {
        $array = [$product->getId()=>new CartSessionObject($product->getId(), 4)];
        $session->set(CartSessionProductService::CART_SESSION_KEY, $array);
        $session->save();
    }


}