<?php

namespace App\Tests\Controller\Module\WebShop\External\Order;

use App\Entity\OrderHeader;
use App\Factory\OrderHeaderFactory;
use App\Tests\Fixtures\CartFixture;
use App\Tests\Fixtures\CustomerAddressFixture;
use App\Tests\Fixtures\CustomerFixture;
use App\Tests\Fixtures\PriceFixture;
use App\Tests\Fixtures\WebShopAddressFixture;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Browser;
use Zenstruck\Browser\Test\HasBrowser;

class OrderCreateControllerTest extends WebTestCase
{
    use HasBrowser, CustomerFixture, CustomerAddressFixture, PriceFixture, CartFixture,
        WebShopAddressFixture;

    public function testCreate()
    {
        /** @var OrderHeader $orderHeader */
        $orderHeader = null;

        // without logging in
        // goto signup
        $uri = "/web-shop/order/create";
        $this
            ->browser()
            ->use(function (KernelBrowser $browser) {

                $this->createCartInSession($browser);
                $this->createCustomer();
                $this->createCustomerAddressInSession($this->customer);
                $browser->loginUser($this->user->object());

            })
            ->interceptRedirects()
            ->visit($uri)
            ->use(function (Browser $browser) use ($orderHeader) {
                $orderHeader = OrderHeaderFactory::find(['customer' => $this->customer]);


            })
            ->assertRedirectedTo("/order/{$orderHeader->getId()}/success");

    }
}
