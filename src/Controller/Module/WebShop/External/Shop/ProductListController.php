<?php

namespace App\Controller\Module\WebShop\External\Shop;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductListController extends AbstractController
{

    public function list(ProductRepository $productRepository, Request $request): Response
    {
        $products = $productRepository->findAll();
        return $this->render(
            'module/web_shop/external/product/web_shop_product_list.html.twig',
            ['products' => $products]
        );
    }

}