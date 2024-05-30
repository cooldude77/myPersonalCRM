<?php

namespace App\Tests\Fixtures;

use App\Service\Module\WebShop\External\Cart\Session\CartSessionService;
use App\Service\Module\WebShop\External\Cart\Session\Object\CartSessionObject;
use App\Tests\Utility\MySessionFactory;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;

trait CartFixture
{
    private function createCartInSession(KernelBrowser $browser): void
    {
        /** @var MySessionFactory $factory */
        $factory = $browser->getContainer()->get('session.factory');

        $session = $factory->createSession();
        $array = [new CartSessionObject(1, 4), new CartSessionObject(1.5)];
        $session->set(CartSessionService::CART_SESSION_KEY, $array);
        $session->save();
    }


}