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

class ShopController extends AbstractController
{
    /**
     * @throws Exception
     */
    #[Route('/shop', name: 'module_web_shop')]
    public function shop(CategoryRepository $categoryRepository,
        ProductRepository $productRepository,
        WebShopAddProductToCartDTOMapper $addProductToCartDTOMapper,
        CartUpdateService $cartUpdateService, Request $request
    ): Response {

        $categories = $categoryRepository->findAll();

        $products = $productRepository->findBy(['category' => $categories]);

        $DTOArray = $addProductToCartDTOMapper->createDTOArray($products);

        $form = $this->createForm(WebShopAddProductCollectionForm::class, ['products' => $DTOArray]
        );

        $session = $request->getSession();

        $cart = $session->get('cart');
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            /** @var ArrayCollection $array */
            $array = $form->getData()['products'];
            $cartUpdateService->updateCartWithArrayOfProducts(
                $request->getSession(), $array->toArray()
            );

        }

        return $this->render(
            'module/web_shop/external/web_shop_home.html.twig',
            ['categories' => $categories, 'form' => $form]
        );
    }

}