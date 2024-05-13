<?php

namespace App\Controller\Module\WebShop\External\Category;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WebShopCategoryController extends AbstractController
{
    #[Route('/shop/category/hierarchy/list', name: 'module_web_shop_category_hierarchy_list')]
    public function hierarchyList( CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findTopLevelCategories();

        return $this->render(
            'module/web_shop/external/category/web_shop_category_hierarchy.html.twig',
            ['categories' => $categories]
        );
    }
}