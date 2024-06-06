<?php

namespace App\Controller\Module\WebShop\External\Shop;

use App\Controller\Module\WebShop\External\Category\CategoryController;
use App\Controller\Module\WebShop\External\Product\ProductController;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ContentController extends AbstractController
{

    public function content(Request $request): Response
    {

        return $this->forward(ProductController::class . '::' . 'list', ['request' => $request]);
    }

}