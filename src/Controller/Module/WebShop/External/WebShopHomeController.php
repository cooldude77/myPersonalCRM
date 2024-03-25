<?php

namespace App\Controller\Module\WebShop\External;

use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use App\Repository\WebShopRepository;
use App\Repository\WebShopHomeSectionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WebShopHomeController extends AbstractController
{
    #[Route('/shop/home/{name}', name: 'module_web_shop_home')]
    public function home(string $name, WebShopRepository $webShopHomeRepository, WebShopHomeSectionRepository $webShopHomeSectionRepository, Request $request, ProductRepository $productRepository, CategoryRepository $categoryRepository): Response
    {
        $webShop = $webShopHomeRepository->findOneBy(['name' => $name]);
        $webShopSection = $webShopHomeSectionRepository->findBy(['webShopHome' => $webShop]);

        $products = $productRepository->findAll();
        $categories = $categoryRepository->findAll();
        return $this->render('module/web_shop/external/web_shop_home.html.twig',
            ['webShopHome' => $webShop, 'webShopHomeSection' => $webShopSection,
             'products'    => $products,
             'categories'  => $categories]);
    }

}