<?php

namespace App\Controller\Module\WebShop\External\CheckOut;

use App\Exception\Module\WebShop\CheckOut\NoItemsInCartException;
use App\Service\Module\WebShop\External\Cart\Session\CartSessionService;
use App\Service\Module\WebShop\External\CheckOut\Address\CheckOutAddressService;
use App\Service\Module\WebShop\External\CheckOut\CheckOutService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CheckOutController extends AbstractController
{

    /**
     * @throws NoItemsInCartException
     */
    #[Route('/checkout', name: 'web_shop_checkout')]
    public function checkout(CartSessionService $cartService,
        CheckOutAddressService $checkOutAddressService,
        CheckoutService $checkoutService
    ): Response {


        // The checkout page will display appropriate twig templates
        // after following processes, the control should come back to this method
        // and if everything is ok redirect to payment page


        if (!$cartService->hasItems()) {
            throw  new NoItemsInCartException();
        }

        if(!$checkOutAddressService->isShippingAddressSet())


        if(!$checkOutAddressService->isBillingAddressSet())
            throw  new BillingAddressNotSetException();

        if ($checkoutService->isEverythingOkay()) {
            $this->redirectToRoute('web_shop_payment');
        }

        return $this->render(
            'module/web_shop/external/checkout/page/checkout_page.html.twig'
        );
    }
}