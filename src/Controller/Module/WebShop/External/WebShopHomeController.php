<?php

namespace App\Controller\Module\WebShop\External;

use App\Repository\WebShopHomeRepository;
use App\Repository\WebShopHomeSectionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WebShopHomeController extends AbstractController
{
    #[Route('/shop/home/{name}', name: 'module_web_shop_home')]
    public function home(string                       $name, WebShopHomeRepository $webShopHomeRepository,
                         WebShopHomeSectionRepository $webShopHomeSectionRepository,
                         Request                      $request): Response
    {
        $webShop = $webShopHomeRepository->findOneBy(['name' => $name]);
        $webShopSection = $webShopHomeSectionRepository->findBy(['webShopHome' => $webShop]);
        return $this->render('module/web_shop/external/web_shop_home.html.twig', ['webShopHome' => $webShop, 'webShopHomeSection' => $webShopSection]);
    }

}