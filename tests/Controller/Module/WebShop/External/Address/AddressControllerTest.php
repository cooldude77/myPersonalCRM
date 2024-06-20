<?php

namespace App\Tests\Controller\Module\WebShop\External\Address;

use App\Controller\Component\Routing\RoutingConstants;
use App\Factory\CustomerAddressFactory;
use App\Service\Module\WebShop\External\Address\CheckOutAddressSession;
use App\Tests\Fixtures\CustomerFixture;
use App\Tests\Fixtures\LocationFixture;
use App\Tests\Fixtures\SessionFactoryFixture;
use App\Tests\Utility\SelectElement;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Browser;
use Zenstruck\Browser\Test\HasBrowser;

class AddressControllerTest extends WebTestCase
{
    use HasBrowser, CustomerFixture, LocationFixture, SelectElement, SessionFactoryFixture;


    private \Zenstruck\Foundry\Proxy|\App\Entity\CustomerAddress $shippingAddress;
    private \Zenstruck\Foundry\Proxy|\App\Entity\CustomerAddress $billingAddress;

    public function testCreateAddressesWhenNoAddressesPresent()
    {
        $this->createCustomer();
        $this->createLocationFixtures();


        $uri = "/checkout/addresses?" . RoutingConstants::REDIRECT_UPON_SUCCESS_URL . '=/checkout';
        $this
            ->browser()
            ->use(callback: function (Browser $browser) {
                $browser->client()->loginUser($this->userForCustomer->object());
            })
            // address exists
            ->interceptRedirects()
            ->visit($uri)
            ->assertRedirectedTo(
                '/checkout/address/create?type=shipping&_redirect_upon_success_url=/checkout/addresses',
                1
            )
            ->use(callback: function (Browser $browser) {

                // assume address is created
                $this->shippingAddress = CustomerAddressFactory::createOne(
                    ['customer' => $this->customer,
                     'addressType' => 'shipping',
                     'line1' => 'A Good House']
                );

            })
            ->interceptRedirects()
            ->visit($uri)
            ->assertRedirectedTo(
                '/checkout/address/create?type=billing&_redirect_upon_success_url=/checkout/addresses',
                1
            )
            ->use(callback: function (Browser $browser) {

                // assume address is created
                $this->billingAddress = CustomerAddressFactory::createOne(
                    ['customer' => $this->customer,
                     'addressType' => 'billing',
                     'line1' => 'A Good House']
                );
            })
            ->interceptRedirects()
            ->visit($uri)
            ->assertRedirectedTo(
                '/checkout/addresses/choose?type=shipping&_redirect_upon_success_url=/checkout/addresses',
                1
            )
            ->use(callback: function (KernelBrowser $browser) {
                $this->createSession($browser);

                $this->session->set(
                    CheckOutAddressSession::SHIPPING_ADDRESS_ID,
                    $this->shippingAddress->getId()
                );

            })
            ->interceptRedirects()
            ->visit($uri)
            ->assertRedirectedTo(
                '/checkout/addresses/choose?type=billing&_redirect_upon_success_url=/checkout/addresses',
                1
            )
            ->use(callback: function (KernelBrowser $browser) {

                $this->session->set(
                    CheckOutAddressSession::BILLING_ADDRESS_ID,
                    $this->billingAddress->getId()
                );

            })
            ->interceptRedirects()
            ->visit($uri)
            ->assertRedirectedTo('/checkout', 1);


    }


    public function testCreateAddressShipping()
    {
        $this->createCustomer();
        $this->createLocationFixtures();

        $uri = "/checkout/address/create?type=shipping&" .
            RoutingConstants::REDIRECT_UPON_SUCCESS_URL . '=/checkout/addresses';
        $this
            ->browser()
            ->use(callback: function (Browser $browser) {
                $browser->client()->loginUser($this->userForCustomer->object());
            })
            ->interceptRedirects()
            ->visit($uri)
            ->use(function (Browser $browser) {
                $this->addOption($browser, 'select', $this->pinCode->getId());
            })
            ->fillField(
                'address_create_and_choose_form[address][line1]', 'Line 1'
            )
            ->fillField(
                'address_create_and_choose_form[address][line2]', 'Line 2'
            )
            ->fillField(
                'address_create_and_choose_form[address][line3]', 'Line 3'
            )
            ->fillField(
                'address_create_and_choose_form[address][pinCode]', $this->pinCode->getId()
            )
            ->fillField(
                'address_create_and_choose_form[address][addressType]', 'shipping'
            )
            ->checkField(
                'address_create_and_choose_form[address][isDefault]'
            )->checkField('address_create_and_choose_form[isChosen]')
            ->click('Save')
            ->assertRedirectedTo('/checkout/addresses', 1)
            ->use(function (KernelBrowser $browser) {
                $this->createSession($browser);
                self::assertNotNull(
                    $this->session->get(CheckOutAddressSession::SHIPPING_ADDRESS_ID)
                );

            });
    }

    public function testCreateAddressBilling()
    {
        $this->createCustomer();
        $this->createLocationFixtures();

        $uri = "/checkout/address/create?type=billing&" .
            RoutingConstants::REDIRECT_UPON_SUCCESS_URL . '=/checkout/addresses';

        $this
            ->browser()
            ->use(callback: function (Browser $browser) {
                $browser->client()->loginUser($this->userForCustomer->object());
            })
            ->interceptRedirects()
            ->visit($uri)
            ->use(function (Browser $browser) {
                $this->addOption($browser, 'select', $this->pinCode->getId());
            })
            ->fillField(
                'address_create_and_choose_form[address][line1]', 'Line 1'
            )
            ->fillField(
                'address_create_and_choose_form[address][line2]', 'Line 2'
            )
            ->fillField(
                'address_create_and_choose_form[address][line3]', 'Line 3'
            )
            ->fillField(
                'address_create_and_choose_form[address][pinCode]', $this->pinCode->getId()
            )
            ->fillField(
                'address_create_and_choose_form[address][addressType]', 'billing'
            )
            ->checkField(
                'address_create_and_choose_form[address][isDefault]'
            )->checkField('address_create_and_choose_form[isChosen]')
            ->click('Save')
            ->assertRedirectedTo('/checkout/addresses', 1)
            ->use(function (KernelBrowser $browser) {
                $this->createSession($browser);
                self::assertNotNull(
                    $this->session->get(CheckOutAddressSession::BILLING_ADDRESS_ID)
                );

            });
        //todo: check redirect
    }


    public function testChooseAddressesFromMultipleShippingAddresses()
    {
        $this->createCustomer();
        $this->createLocationFixtures();


        // one address is created already

        $address1 = CustomerAddressFactory::createOne(
            ['customer' => $this->customer, 'addressType' => 'shipping', 'line1' => 'A Good House']
        );
        $address2 = CustomerAddressFactory::createOne(
            ['customer' => $this->customer, 'addressType' => 'shipping', 'line1' => 'A New House']
        );


        $uri = "/checkout/addresses/choose?type=shipping";
        $this
            ->browser()
            ->use(callback: function (Browser $browser) {
                $browser->client()->loginUser($this->userForCustomer->object());
            })
            ->visit($uri)
            ->assertContains("A Good House\n");

    }
}