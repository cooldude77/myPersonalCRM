<?php

namespace App\Controller\Module\WebShop\External\Product;

use App\Repository\ProductRepository;
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
            'module/web_shop/external/product/page/web_shop_single_product_display_page.html.twig',
            ['product' => $product]
        );
    }

    #[Route('/shop/product/list', name: 'web_shop_product_list')]
    public function list($code, ProductRepository $productRepository, Request $request): Response
    {
        $products = $productRepository->findAll();
        return $this->render(
            'module/web_shop/external/product/page/web_shop_single_product_display_page.html.twig',
            ['products' => $products]
        );
    }



    #[Route('/locale', name: 'locale')]
    public function setLocale(SessionInterface $session,Request $request)
    {
        $session->set('locale', 'fr_FR');
        return new Response();
    }
}