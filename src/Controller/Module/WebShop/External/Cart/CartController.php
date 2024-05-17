<?php

namespace App\Controller\Module\WebShop\External\Cart;

use App\Form\Module\WebShop\External\Cart\CartMultipleEntryForm;
use App\Form\Module\WebShop\External\Cart\CartSingleEntryForm;
use App\Form\Module\WebShop\External\Cart\DTO\CartProductDTO;
use App\Repository\ProductRepository;
use App\Service\Module\WebShop\External\Cart\CartService;
use App\Service\Module\WebShop\External\Cart\Mapper\CartDTOMapper;
use App\Service\Module\WebShop\External\Cart\Object\CartObject;
use Doctrine\Common\Collections\ArrayCollection;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;

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

    #[Route('/cart/product/{id}/add', name: 'web_shop_product_add_to_cart')]
    public function addToCart($id, ProductRepository $productRepository,
        CartService $cartService,
        Request $request,
        RouterInterface $router
    ):
    Response {

        $product = $productRepository->find($id);

        $cartProductDTO = new CartProductDTO();
        $cartProductDTO->productId = $product->getId();

        $form = $this->createForm(
            CartSingleEntryForm::class, $cartProductDTO,
            ['action' => $router->generate('web_shop_product_add_to_cart', ['id' => $id])]
        );

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $cartProductDTO = $form->getData();

            $cartObject = new CartObject(
                $cartProductDTO->productId, $cartProductDTO->quantity
            );

            $cartService->initialize();
            $cartService->addProductToCart($cartObject);

            // Todo : event after cart update

            return new Response("Product Added Successfully");

        }

        $error = $form->getErrors(true);
        return $this->render(
            'module/web_shop/external/cart/add_to_cart_form.html.twig',
            ['form' => $form]
        );
    }

    #[Route('/cart/clear', name: 'cart_clear')]
    public function clear(
        CartService $cartService
    ):
    Response {

        $cartService->initialize();
        $cartService->clearCart();
        return new Response("Cart Cleared");

    }

}