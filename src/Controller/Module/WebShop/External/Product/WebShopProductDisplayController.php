<?php

namespace App\Controller\Module\WebShop\External\Product;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WebShopProductDisplayController extends AbstractController
{
    #[Route('/shop/product/{code}', name: 'module_web_shop_product_display')]
    public function home($code,
                         ProductRepository $productRepository,
                         Request $request): Response
    {
        $product = $productRepository->findOneBy(['code' => $code]);
        return $this->render('module/web_shop/external/product/web_shop_product_display.html.twig',
            ['product' => $product]);
    }

}