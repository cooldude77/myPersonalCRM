<?php

namespace App\Service\Module\WebShop\External\Cart\Session;

use App\Service\Module\WebShop\External\Cart\Session\Object\CartSessionObject;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;

class CartSessionService
{
    public final const string CART_SESSION_KEY = '_WEB_SHOP_CART';

    private Session $session;

    public function __construct(private readonly RequestStack $requestStack)
    {
        // Accessing the session in the constructor is *NOT* recommended, since
        // it might not be accessible yet or lead to unwanted side-effects
        // $this->session = $requestStack->getSession();
    }

    public function initialize(): void
    {
        $this->session = $this->requestStack->getSession();

        if (empty($this->session->get(self::CART_SESSION_KEY))) {
            $this->setCartArrayInSession();
        }
    }

    private function setCartArrayInSession(array $array = []): void
    {
        // always serialize
        $this->session->set(self::CART_SESSION_KEY, $array);
    }

    public function addItemToCart(CartSessionObject $cartObject): void
    {
        // Todo: check quantity proper values

        // todo: check product
        //if($this->productRepository->find($productId)==null)
        //  throw new NoSuchProductException($id);

        $this->setCartObject($cartObject);

    }

    private function setCartObject(CartSessionObject $cartObject): void
    {
        $array = $this->getCartArray();
        // todo: validations
        $array[$cartObject->productId] = $cartObject;

        $this->setCartArrayInSession($array);

    }

    public function getCartArray(): array
    {


        $x = $this->session->get(self::CART_SESSION_KEY);

        return $x;
    }

    public function clearCart(): void
    {
        $this->setCartArrayInSession([]);
        $this->session->remove(self::CART_SESSION_KEY);

    }

    public function updateItemArray(\Doctrine\Common\Collections\ArrayCollection $array): void
    {
        $cartArray = $this->getCartArray();
        /** CartSessionObject $item */
        foreach ($array as $item) {
            $cartArray[$item->productId] = $item;
        }
        $this->setCartArrayInSession($cartArray);
    }

    public function deleteItem($id)
    {
        $cartArray = $this->getCartArray();
        unset($cartArray[$id]);

        $this->setCartArrayInSession($cartArray);

    }

    public function hasItems(): bool
    {
        return !empty($this->getCartArray());
    }


}