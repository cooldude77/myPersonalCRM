<?php

namespace App\Controller\Module\WebShop\External;

use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WebShopByCategoryController extends AbstractController
{
    #[Route('/shop/category', name: 'module_web_shop_category_all')]
    public function home(CategoryRepository $categoryRepository,
                         ProductRepository  $productRepository,
                         Request            $request): Response
    {
        $categories = $categoryRepository->findAll();
        $products = $productRepository->findBy(['category' => $categories]);
        return $this->render('module/web_shop/external/web_shop_by_category.html.twig',
            ['categories' => $categories,
                'products' => $products]);
    }

}