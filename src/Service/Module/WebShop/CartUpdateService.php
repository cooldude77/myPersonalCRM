<?php

namespace App\Service\Module\WebShop;

use App\Form\Module\WebShop\External\ShopHome\DTO\WebShopProductDTO;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartUpdateService
{

    public final const string CART_SESSION_KEY = 'WEB_SHOP_CART_SESSION_KEY';
    private SessionInterface $session;


    public function updateCartWithArrayOfProducts(SessionInterface $session,
                               array            $webShopProductDTOArray): void
    {

        $this->createCart($session);

        $cart = $session->get(self::CART_SESSION_KEY);


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
        if (empty($session->get(self::CART_SESSION_KEY)))
            $session->set(self::CART_SESSION_KEY,
            array());

        if (empty($cart['products'])) $cart = array('products' => array());

        $session->set(self::CART_SESSION_KEY, $cart);
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
        return $this->session->get(self::CART_SESSION_KEY);
    }

    /**
     * @param $cart
     * @return void
     */
    public function setCart(array $cart): void
    {
        $this->session->set(self::CART_SESSION_KEY, $cart);
    }

    private function removeProduct(?int $productId): void
    {
        $cart = $this->getCart();
        unset($cart['products'][$productId]);
        $this->setCart($cart);

    }

    public function updateCartWithProductId($id)
    {
    }

}