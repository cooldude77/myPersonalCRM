<?php

namespace App\Controller\Module\WebShop\External\Cart;

use App\Form\Module\WebShop\External\ShopHome\Mapper\WebShopAddProductToCartDTOMapper;
use App\Form\Module\WebShop\External\ShopHome\WebShopAddProductCollectionForm;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use App\Service\Module\WebShop\CartUpdateService;
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
    public function home( WebShopAddProductToCartDTOMapper $addProductToCartDTOMapper, CartUpdateService $cartUpdateService, Request $request): Response
    {


        $session = $request->getSession();

        $cart = $session->get(CartUpdateService::CART_SESSION_KEY);

        $DTOArray = $addProductToCartDTOMapper->createDTOArrayFromArrayList($cart['products']);
        $form = $this->createForm(WebShopAddProductCollectionForm::class, ['products' => $DTOArray]);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

                /** @var ArrayCollection $array */
                $array = $form->getData()['products'];
               $cartUpdateService->updateCartWithArrayOfProducts($request->getSession(),$array->toArray());

           //     if($form->get('cart')->isClicked())
                   // $x = 10;
        }

        return $this->render('module/web_shop/external/cart/cart_page.html.twig', ['form' => $form]);
    }

}