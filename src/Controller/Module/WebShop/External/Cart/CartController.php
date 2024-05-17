<?php

namespace App\Controller\Module\WebShop\External\Cart;

use App\Form\Module\WebShop\External\Cart\CartMultipleEntryForm;
use App\Form\Module\WebShop\External\Cart\Mapper\CartDTOMapper;
use App\Service\Module\WebShop\Cart\CartService;
use Doctrine\Common\Collections\ArrayCollection;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    /**
     * @throws Exception
     */
    #[Route('/cart', name: 'module_web_shop_cart')]
    public function cart(CartDTOMapper $cartDTOMapper, CartService $cartService,
        Request $request
    ): Response {


        $cartService->initialize();

        $DTOArray = $cartDTOMapper->mapCartToDto($cartService->getCartArray());

        $form = $this->createForm(CartMultipleEntryForm::class, ['items' => $DTOArray]);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            /** @var ArrayCollection $array */
            $array = $form->getData();
          //  $cartService->addProductToCart($array);

            //     if($form->get('cart')->isClicked())
            // $x = 10;
        }

        return $this->render('module/web_shop/external/cart/page/cart_page.html.twig', ['form' =>
                                                                                         $form]
        );
    }

}