<?php

namespace App\Controller\Module\WebShop\External\CheckOut;

use App\Repository\CustomerAddressRepository;
use App\Repository\CustomerRepository;
use App\Service\Module\WebShop\External\Cart\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CheckOutController extends AbstractController
{

    #[Route('/checkout', name: 'web_shop_checkout')]
    public function checkout(CartService $cartService): Response {
        // if user is already logged in

      //  if(!$cartService->hasItems())
        // throw  new CheckoutNoItemsInCartException();

        $user= $this->getUser();
        return $this->render(
            'module/web_shop/external/checkout/page/checkout_page.html.twig'
        );
    }
}