<?php

namespace App\Controller\Module\WebShop\External\Product;

use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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

    public function list(ProductRepository $productRepository,
        CategoryRepository $categoryRepository,
        Request $request
    ): Response {

        if ($request->query->get('category') != null) {

            $category = $categoryRepository->findOneBy(['name' => $request->get('category')]);
            $products = $productRepository->findBy(['category' => $category]);
        } else {
            $products = $productRepository->findAll();
        }

        return $this->render(
            'module/web_shop/external/product/web_shop_product_list.html.twig',
            ['products' => $products]
        );
    }

    public function listBySearchTerm(Request $request, ProductRepository $productRepository
    ): Response {
        $products = $productRepository->search($request->get('searchTerm'));

        return $this->render(
            'module/web_shop/external/product/web_shop_product_list.html.twig',
            ['products' => $products]
        );


    }

}