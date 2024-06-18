<?php

namespace App\Tests\Controller\Module\WebShop\External\Address;

use App\Factory\CustomerAddressFactory;
use App\Tests\Fixtures\EmployeeFixture;
use App\Tests\Fixtures\LocationFixture;
use App\Tests\Utility\SelectElement;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Browser;
use Zenstruck\Browser\Test\HasBrowser;

class AddressControllerTest extends WebTestCase
{
    use HasBrowser, EmployeeFixture, LocationFixture, SelectElement;

    public function testCreateAddressBilling()
    {
        $this->createCustomer();
        $this->createLocationFixtures();

        $uri = "/checkout/address/create?type=\"billing\"";
        $this
            ->browser()
            ->use(callback: function (Browser $browser) {
                $browser->client()->loginUser($this->user->object());
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
            ->assertRedirectedTo('/checkout')
            ->assertSuccessful();
        //todo: check redirect
    }

    public function testCreateAddressShipping()
    {
        $this->createCustomer();
        $this->createLocationFixtures();

        $uri = "/checkout/address/create?id={$this->customer->getId()}&type=\"shipping\"";
        $this
            ->browser()
            ->use(callback: function (Browser $browser) {
                $browser->client()->loginUser($this->user->object());
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
            ->assertRedirectedTo('/checkout');
        //todo: check redirect
    }

    public function testChooseAddressesWhenNoAddressesPresent()
    {
        $this->createCustomer();
        $this->createLocationFixtures();


        $uri = "/checkout/addresses";
        $this
            ->browser()
            ->use(callback: function (Browser $browser) {
                $browser->client()->loginUser($this->user->object());
            })
            ->visit($uri)
            ->assertSee("Add Billing Address")
            ->assertSee('Add Shipping Address');

        // one address is created already

        $address1 = CustomerAddressFactory::createOne(
            ['customer' => $this->customer, 'addressType' => 'shipping', 'line1' => 'A Good House']
        );

        $uri = "/checkout/addresses";
        $this
            ->browser()
            ->use(callback: function (Browser $browser) {
                $browser->client()->loginUser($this->user->object());
            })
            ->visit($uri)
            ->use(callback: function (Browser $browser) {
                $respone = $browser->client()->getResponse();
            })
            ->assertContains($address1->getLine1())
            ->assertSee('Add Shipping Address');

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
                $browser->client()->loginUser($this->user->object());
            })
            ->visit($uri)
            ->assertContains("A Good House\n");

    }
}