<?php

namespace App\Controller\Module\WebShop\External\Product;

use App\Form\Module\WebShop\External\Cart\CartSingleEntryForm;
use App\Form\Module\WebShop\External\Cart\DTO\CartProductDTO;
use App\Repository\ProductRepository;
use App\Service\Module\WebShop\Cart\CartService;
use App\Service\Module\WebShop\Cart\Object\CartObject;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/product/{name}', name: 'web_shop_product_single_display')]
    public function home($name, ProductRepository $productRepository, Request $request): Response
    {
        $product = $productRepository->findOneBy(['name' => $name]);
        return $this->render(
            'module/web_shop/external/product/web_shop_single_product_display_page.html.twig',
            ['product' => $product]
        );
    }

    #[Route('/shop/product/list', name: 'web_shop_product_list')]
    public function list($code, ProductRepository $productRepository, Request $request): Response
    {
        $products = $productRepository->findAll();
        return $this->render(
            'module/web_shop/external/product/web_shop_single_product_display_page.html.twig',
            ['products' => $products]
        );
    }

    #[Route('/web-shop/cart/product/{id}/add', name: 'web_shop_product_add_to_cart')]
    public function addToCartSection($id, ProductRepository $productRepository,
        CartService $cartService,
        Request $request,
        SessionInterface $session
    ):
    Response {

        $product = $productRepository->find($id);

        $webShopProductDTO = new CartProductDTO();
        $webShopProductDTO->productId = $product->getId();

        $form = $this->createForm(CartSingleEntryForm::class, $webShopProductDTO);
        $session->start();
        $cookies = $request->cookies;
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $webShopProductDTO = $form->getData();

            $cartObject = new CartObject(
                $webShopProductDTO->productId, $webShopProductDTO->quantity
            );

            $cartService->initialize();
            $cartService->addProductToCart($cartObject);

            // Todo : event after cart update

            return new Response("Product Added Successfully");

        }

        $error = $form->getErrors(true);
        return $this->render(
            'module/web_shop/external/shop/add_to_cart_form.html.twig',
            ['form' => $form]
        );
    }

    #[Route('/locale', name: 'locale')]
    public function setLocale(SessionInterface $session,Request $request)
    {
        $session->set('locale', 'fr_FR');
        return new Response();
    }
}