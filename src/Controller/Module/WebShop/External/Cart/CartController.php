<?php

namespace App\Controller\Module\WebShop\External\Cart;

use App\Controller\Component\UI\Panel\Components\PanelContentController;
use App\Controller\Component\UI\Panel\Components\PanelHeaderController;
use App\Controller\Component\UI\PanelMainController;
use App\Controller\Module\WebShop\External\Shop\HeaderController;
use App\Form\Module\WebShop\External\Cart\CartMultipleEntryForm;
use App\Form\Module\WebShop\External\Cart\CartSingleEntryForm;
use App\Form\Module\WebShop\External\Cart\DTO\CartProductDTO;
use App\Repository\ProductRepository;
use App\Service\Module\WebShop\External\Cart\Session\CartSessionService;
use App\Service\Module\WebShop\External\Cart\Session\Mapper\CartSessionToDTOMapper;
use App\Service\Module\WebShop\External\Cart\Session\Object\CartSessionObject;
use Doctrine\Common\Collections\ArrayCollection;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;

class CartController extends AbstractController
{
    /**
     * @throws Exception
     */
    #[Route('/cart', name: 'module_web_shop_cart')]
    public function main(Request $request): Response
    {


        $session = $request->getSession();

        $session->set(
            PanelHeaderController::HEADER_CONTROLLER_CLASS_NAME, HeaderController::class
        );
        $session->set(
            PanelHeaderController::HEADER_CONTROLLER_CLASS_METHOD_NAME,
            'header'
        );
        $session->set(
            PanelContentController::CONTENT_CONTROLLER_CLASS_NAME, self::class
        );
        $session->set(
            PanelContentController::CONTENT_CONTROLLER_CLASS_METHOD_NAME,
            'list'
        );
        $session->set(
            PanelMainController::BASE_TEMPLATE,
            'module/web_shop/external/base/web_shop_base_template.html.twig'
        );

        return $this->forward(PanelMainController::class . '::main', ['request' => $request]);

    }

    public function list(CartSessionToDTOMapper $cartDTOMapper, CartSessionService $cartService,
        Request $request
    ): Response {


        $cartService->initialize();

        $DTOArray = $cartDTOMapper->mapCartToDto($cartService->getCartArray());

        $form = $this->createForm(CartMultipleEntryForm::class, ['items' => $DTOArray]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var ArrayCollection $array */
            $array = $form->getData()['items'];
            $cartService->updateItemArray($array);

        }

        $products = $cartService->getProductListFromCartArray();
        return $this->render(
            'module/web_shop/external/cart/cart_list.html.twig',
            [
                'products' => $products,
                'form' => $form
            ]
        );
    }

    #[Route('/cart/product/{id}/add', name: 'module_web_shop_cart_add_product')]
    public function addToCart($id, ProductRepository $productRepository,
        CartSessionService $cartService,
        Request $request,
        RouterInterface $router
    ):
    Response {

        $product = $productRepository->find($id);

        $cartProductDTO = new CartProductDTO();
        $cartProductDTO->productId = $product->getId();

        $form = $this->createForm(
            CartSingleEntryForm::class, $cartProductDTO,
            ['action' => $router->generate('module_web_shop_cart_add_product', ['id' => $id])]
        );

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $cartProductDTO = $form->getData();

            $cartObject = new CartSessionObject(
                $cartProductDTO->productId, $cartProductDTO->quantity
            );

            $cartService->initialize();
            $cartService->addItemToCart($cartObject);

            // Todo : event after cart update

            return new Response("Product Added Successfully");

        }

        $error = $form->getErrors(true);
        return $this->render(
            'module/web_shop/external/cart/add_to_cart_form.html.twig',
            ['form' => $form]
        );
    }

    #[Route('/cart/product/{id}/delete', name: 'module_web_shop_cart_delete_product')]
    public function delete($id, ProductRepository $productRepository,
        CartSessionService $cartService,
        Request $request,
        RouterInterface $router
    ):
    Response {

        $cartService->initialize();
        $cartService->deleteItem($id);


        return new Response("Item Deleted");
    }

    #[Route('/cart/clear', name: 'module_web_shop_cart_clear')]
    public function clear(
        CartSessionService $cartService
    ):
    Response {

        $cartService->initialize();
        $cartService->clearCart();
        return new Response("Cart Cleared");

    }

}