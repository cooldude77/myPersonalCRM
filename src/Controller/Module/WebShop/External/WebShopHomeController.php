<?php

namespace App\Controller\Module\WebShop\External;

use App\Repository\WebShopHomeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WebShopHomeController extends AbstractController
{
    #[Route('/shop/home', name: 'module_web_shop_home')]
    public function home(WebShopHomeRepository $webShopHomeRepository, Request $request): Response
    {
        $webShop = $webShopHomeRepository->findOneBy(['name' => 'Webshop']);
        return $this->render('module/web_shop/external/web_shop.html.twig', ['webShop' => $webShop]);
    }

}