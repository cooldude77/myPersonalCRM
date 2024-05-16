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
use function PHPUnit\Framework\assertNotNull;

class ShopHomePageController extends AbstractController
{
    #[Route('/test', name: 'module_web_shop_home_page')]
    public function home(WebShopRepository $webShopHomeRepository,
WebShopHomeSectionRepository $webShopHomeSectionRepository, Request $request, ProductRepository $productRepository, CategoryRepository $categoryRepository): Response
    {
        $webShop = $webShopHomeRepository->findOneBy(['name' => 'Default']);
        assertNotNull($webShop);
        $webShopSection = $webShopHomeSectionRepository->findBy(['webShop' => $webShop]);

         return $this->render('module/web_shop/external/web_shop_home.html.twig',
            ['webShop' => $webShop, 'webShopSection' => $webShopSection]);
    }

}