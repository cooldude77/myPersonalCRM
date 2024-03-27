<?php

namespace App\Service\Module\WebShop;

use App\Form\Module\WebShop\External\DTO\WebShopProductDTO;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartUpdateService
{

    private SessionInterface $session;

    public function updateCart(SessionInterface $session,
                               array            $webShopProductDTOArray): void
    {

        $this->createCart($session);

        $cart = $session->get('cart');


        /** @var WebShopProductDTO $product */
        foreach ($webShopProductDTOArray as $product) {

            if ($product->quantity > 0) {
                if ($this->productExists($product->productId))
                    // or update it
                    $this->updateProductWithQuantity($product->productId, $product->quantity);

                else // create key if it does not exit
                    $this->createProductWithQuantity($product->productId, $product->quantity);

            } else {
                if (isset($cart['$products'][$product->productId])) // if key exists, remove it
                    $this->removeProduct($product->productId) ;
            }
        }


    }

    public function createCart(SessionInterface $session): void
    {
        $this->session = $session;
        if (empty($session->get('cart'))) $session->set('cart',
            array());

        if (empty($cart['products'])) $cart = array('products' => array());

        $session->set('cart', $cart);
    }

    private function productExists(int $productId): bool
    {
        return isset($this->getCart()['products'][$productId]);
    }

    private function updateProductWithQuantity(?int $productId, int $quantity): void
    {
       $cart = $this->getCart();
        $cart['products'][$productId] = $quantity;
        $this->setCart($cart);

    }

    private function createProductWithQuantity(?int $productId, int $quantity): void
    {
        $cart = $this->getCart();
        $cart['products'][$productId] = $quantity;
        $this->setCart($cart);
    }

    /**
     * @return mixed
     */
    public function getCart(): array
    {
        return $this->session->get('cart');
    }

    /**
     * @param $cart
     * @return void
     */
    public function setCart(array $cart): void
    {
        $this->session->set('cart', $cart);
    }

    private function removeProduct(?int $productId): void
    {
        $cart = $this->getCart();
        unset($cart['products'][$productId]);
        $this->setCart($cart);

    }

}