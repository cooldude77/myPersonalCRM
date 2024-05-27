<?php

namespace App\Controller\Module\WebShop\External\CheckOut;

use App\Exception\Module\WebShop\CheckOut\NoItemsInCartException;
use App\Service\Module\WebShop\External\Cart\Session\CartSessionService;
use App\Service\Module\WebShop\External\CheckOut\Address\CheckOutAddressService;
use App\Service\Module\WebShop\External\CheckOut\CheckOutService;
use App\Service\Module\WebShop\External\Order\OrderService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CheckOutController extends AbstractController
{


    #[Route('/web-shop/checkout', name: 'web_shop_checkout')]
    public function checkout(CartSessionService $cartSessionService,
        CheckOutAddressService $checkOutAddressService,
        CheckoutService $checkoutService,
        OrderService $orderService,
    RequestStack $requestStack
    ): Response {
        // The checkout page will display appropriate twig templates
        // after following processes, the control should come back to this method
        // and if everything is ok redirect to payment page

        $cartSessionService->initialize();

        try {


            if ($this->getUser() == null) {
                throw new UserNotFoundOrNotLoggedInException();
            }

            if (!$cartSessionService->hasItems()) {
                throw  new NoItemsInCartException();
            }

            if (!$checkOutAddressService->isShippingAddressSet()) {
                throw  new ShippingAddressNotSetException();
            }

            if (!$checkOutAddressService->isBillingAddressSet()) {
                throw  new BillingAddressNotSetException();
            }

        } catch (UserNotFoundOrNotLoggedInException $exception) {
            return $this->redirectToRoute('web_shop_sign_up_or_login');

        } catch (NoItemsInCartException $cartException) {
            return $this->render(
                'module/web_shop/external/checkout/page/checkout_cart_is_empty_page.html.twig'
            );
        } catch (ShippingAddressNotSetException|BillingAddressNotSetException $addressNotSetException) {
            return $this->redirectToRoute(' web_shop_checkout_address');
        }


        return $this->redirectToRoute('web_shop_create_order_after_checkout');

    }
}