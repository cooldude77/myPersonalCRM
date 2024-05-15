<?php

namespace App\Service\Module\WebShop;

use App\Service\Module\WebShop\Object\CartObject;
use Symfony\Component\HttpFoundation\RequestStack;

class CartService
{
    public final const string CART_SESSION_KEY = '_WEB_SHOP_CART';


    public function __construct(private RequestStack $requestStack)
    {
        $this->createCartArrayInSessionIfNotExists();
    }

    private function createCartArrayInSessionIfNotExists(): void
    {
        if (empty($this->requestStack->getSession()->get(self::CART_SESSION_KEY))) {
            $this->setCartArray([]);
        }

    }

    private function setCartArray(array $array = []): void
    {
        $this->requestStack->getSession()->set(self::CART_SESSION_KEY, $array);
    }

    public function addProductToCart(CartObject $cartObject): void
    {
        // Todo: check quantity proper values

        // todo: check product
        //if($this->productRepository->find($productId)==null)
        //  throw new NoSuchProductException($id);

        $this->setCartObject($cartObject);

    }

    private function setCartObject(CartObject $cartObject): void
    {
        $array = $this->getCartArray();
        // todo: validations
        $array[$cartObject->productId] = $cartObject;

        $this->setCartArray($array);

    }

    private function getCartArray(): array
    {
        return $this->requestStack->getSession()->get(self::CART_SESSION_KEY);

    }

    public function increaseByQuantity(int $productId, $quantity): void
    {

        // todo: validations
        $cartObject = $this->getCartObject($productId);
        $cartObject->increaseQuantityBy($quantity);
        $this->setCartObject($cartObject);
    }

    private function getCartObject(int $productId): CartObject
    {
        return $this->getCartArray()[$productId];
    }

    public function decreaseByQuantity(int $productId, $quantity): void
    {
// todo: validations
        $cartObject = $this->getCartObject($productId);
        $cartObject->decreaseQuantityBy($quantity);
        $this->setCartObject($cartObject);
    }


}