<?php

namespace App\Tests\Controller\Module\WebShop\External\Order;

use App\Entity\OrderHeader;
use App\Factory\OrderHeaderFactory;
use App\Tests\Fixtures\CartFixture;
use App\Tests\Fixtures\CurrencyFixture;
use App\Tests\Fixtures\CustomerAddressFixture;
use App\Tests\Fixtures\CustomerAddressInSessionFixture;
use App\Tests\Fixtures\EmployeeFixture;
use App\Tests\Fixtures\LocationFixture;
use App\Tests\Fixtures\PriceFixture;
use App\Tests\Fixtures\ProductFixture;
use App\Tests\Fixtures\SessionFactoryFixture;
use App\Tests\Fixtures\WebShopAddressFixture;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Browser;
use Zenstruck\Browser\Test\HasBrowser;

class OrderCreateControllerTest extends WebTestCase
{
    use HasBrowser,
        LocationFixture,
        EmployeeFixture,
        ProductFixture,
        CurrencyFixture,
        CustomerAddressFixture,
        PriceFixture,
        CartFixture,
        SessionFactoryFixture,
        CustomerAddressInSessionFixture,
        WebShopAddressFixture;

    public function testCreate()
    {

        // without logging in
        // goto signup
        $uri = "/web-shop/order/create";
        $this
            ->browser()
            ->use(function (KernelBrowser $browser) {

                $this->createLocationFixtures();

                $this->createProductFixtures();
                $this->createCurrencyFixtures($this->country);
                $this->createPriceFixtures($this->productA,$this->productB, $this->currency);

                $this->createSession($browser);
                $this->createCartInSession($this->session, $this->productA);

                $this->createCustomer();
                $this->createCustomerAddress($this->customer);
                $this->setAddressesInSession(
                    $browser, $this->addressShipping, $this->addressBilling
                );

                $browser->loginUser($this->user->object());

            })
            ->interceptRedirects()
            ->visit($uri)
            ->use(function (Browser $browser)  {
                $orderHeader = OrderHeaderFactory::find(['customer' => $this->customer]);

                $this->assertNotNull($orderHeader);

                $uri = "/order/{$orderHeader->getId()}/success";
                /** @noinspection PhpPossiblePolymorphicInvocationInspection */
                $browser->assertRedirectedTo($uri);

            });
    }
}
