<?php

namespace App\Controller\Module\WebShop\External;

use App\Form\Module\WebShop\External\ShopHome\Mapper\WebShopAddProductToCartDTOMapper;
use App\Form\Module\WebShop\External\ShopHome\WebShopAddProductCollectionForm;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use App\Service\Module\WebShop\CartUpdateService;
use Doctrine\Common\Collections\ArrayCollection;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WebShopDisplayController extends AbstractController
{
    /**
     * @throws Exception
     */
    #[Route('/shop/category', name: 'module_web_shop_category_all')]
    public function home(CategoryRepository $categoryRepository, ProductRepository $productRepository, WebShopAddProductToCartDTOMapper $addProductToCartDTOMapper, CartUpdateService $cartUpdateService, Request $request): Response
    {
        $categories = $categoryRepository->findAll();
        $products = $productRepository->findBy(['category' => $categories]);

        $DTOArray = $addProductToCartDTOMapper->createDTOArray($products);

        $form = $this->createForm(WebShopAddProductCollectionForm::class, ['products' => $DTOArray]);

        $session = $request->getSession();

        $cart = $session->get('cart');
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

                /** @var ArrayCollection $array */
                $array = $form->getData()['products'];
               $cartUpdateService->updateCartWithArrayOfProducts($request->getSession(),$array->toArray());

           //     if($form->get('cart')->isClicked())
                   // $x = 10;
        }

        return $this->render('module/web_shop/external/web_shop_with_category_and_product.html.twig', ['categories' => $categories, 'form' => $form]);
    }

}