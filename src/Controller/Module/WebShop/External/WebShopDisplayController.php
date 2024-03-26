<?php

namespace App\Controller\Module\WebShop\External;

use App\Form\Module\WebShop\External\DTO\WebShopAddProductDTO;
use App\Form\Module\WebShop\External\Mapper\WebShopAddProductToCartDTOMapper;
use App\Form\Module\WebShop\External\WebShopAddProductCollectionForm;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WebShopDisplayController extends AbstractController
{
    /**
     * @throws Exception
     */
    #[Route('/shop/category', name: 'module_web_shop_category_all')]
    public function home(CategoryRepository               $categoryRepository,
                         ProductRepository                $productRepository,
                         WebShopAddProductToCartDTOMapper $addProductToCartDTOMapper,
                         Request                          $request): Response
    {
        $categories = $categoryRepository->findAll();
        $products = $productRepository->findBy(['category' => $categories]);


        $DTOArray = $addProductToCartDTOMapper->createDTOArray($request->getSession(),
            $products);


        $form = $this->createForm(WebShopAddProductCollectionForm::class,
        ['products'=>$DTOArray]);

$data = $form->getData();
        return $this->render('module/web_shop/external/web_shop_with_category_and_product.html.twig',
            ['categories' => $categories,
             'form'       => $form]);
    }

}