<?php

namespace App\Event\Module\WebShop\External\Cart;

class CartEventTypes
{
    public const string POST_CART_INITIALIZED = 'cart.post.initialized';
    public const string ITEM_ADDED_TO_CART = 'cart.post.item_added';

    public const string ITEM_DELETED_FROM_CART = 'cart.post.item_deleted';

    public const string CART_CLEARED_BY_USER = 'cart.post.cart_cleared_by_user';

}