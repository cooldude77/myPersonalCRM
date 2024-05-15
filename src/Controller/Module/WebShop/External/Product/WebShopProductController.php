<?php

namespace App\Controller\Module\WebShop\External\Product;

use App\Form\Module\WebShop\External\ShopHome\DTO\WebShopProductDTO;
use App\Form\Module\WebShop\External\ShopHome\WebShopAddProductSingleForm;
use App\Repository\ProductRepository;
use App\Service\Module\WebShop\CartService;
use App\Service\Module\WebShop\Object\CartObject;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WebShopProductController extends AbstractController
{
    #[Route('/product/{name}', name: 'web_shop_product_single_display')]
    public function home($name, ProductRepository $productRepository, Request $request): Response
    {
        $product = $productRepository->findOneBy(['name' => $name]);
        return $this->render(
            'module/web_shop/external/product/web_shop_product_display.html.twig',
            ['product' => $product]
        );
    }

    #[Route('/shop/product/list', name: 'web_shop_product_list')]
    public function list($code, ProductRepository $productRepository, Request $request): Response
    {
        $products = $productRepository->findAll();
        return $this->render(
            'module/web_shop/external/product/web_shop_product_display.html.twig',
            ['products' => $products]
        );
    }

    #[Route('/web-shop/cart/product/{id}/add', name: 'web_shop_product_add_to_cart')]
    public function addToCartSection($id, ProductRepository $productRepository,
        CartService $cartService
    ):
    Response {

        $product = $productRepository->find($id);

        $webShopProductDTO = new WebShopProductDTO();
        $webShopProductDTO->productId = $product->getId();

        $form = $this->createForm(WebShopAddProductSingleForm::class, $webShopProductDTO);

        if ($form->isSubmitted() && $form->isValid()) {

            $webShopProductDTO = $form->getData();
            $cartObject = new CartObject(
                $webShopProductDTO->productId, $webShopProductDTO->quantity
            );
            $cartService->addProductToCart($cartObject);

            // Todo : event after cart update

            return new Response("Product Added Successfully");

        }
        return $this->render(
            'module/web_shop/external/shop/add_to_cart_form.html.twig',
            ['form' => $form]
        );
    }

}