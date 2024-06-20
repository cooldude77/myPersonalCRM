<?php

namespace App\Tests\Controller\Module\WebShop\External\Address;

use App\Factory\CustomerAddressFactory;
use App\Tests\Fixtures\CustomerFixture;
use App\Tests\Fixtures\LocationFixture;
use App\Tests\Utility\SelectElement;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Browser;
use Zenstruck\Browser\Test\HasBrowser;

class AddressControllerTest extends WebTestCase
{
    use HasBrowser, CustomerFixture, LocationFixture, SelectElement;


    public function testCreateAddressesWhenNoAddressesPresent()
    {
        $this->createCustomer();
        $this->createLocationFixtures();


        $uri = "/checkout/addresses";
        $this
            ->browser()
            ->use(callback: function (Browser $browser) {
                $browser->client()->loginUser($this->userForCustomer->object());
            })
            // address exists
            ->interceptRedirects()
            ->visit($uri)
            ->assertRedirectedTo('/checkout/address/create?type=shipping', 1)
            ->use(callback: function (Browser $browser) {
                CustomerAddressFactory::createOne(
                    ['customer' => $this->customer,
                     'addressType' => 'shipping',
                     'line1' => 'A Good House']
                );

            })
            ->interceptRedirects()
            ->visit($uri)
            ->assertRedirectedTo('/checkout/address/create?type=billing', 1);
        /*
            ->use(callback: function (Browser $browser) {

                CustomerAddressFactory::createOne(
                    ['customer' => $this->customer,
                     'addressType' => 'billing',
                     'line1' => 'A Good House']
                );
            })
          ->interceptRedirects()
            ->visit($uri)
            ->assertRedirectedTo('/checkout/address/create?type=billing', 1);

        */
    }


    public function testCreateAddressBilling()
    {
        $this->createCustomer();
        $this->createLocationFixtures();

        $uri = "/checkout/address/create?type=\"billing\"";
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
            ->assertRedirectedTo('/checkout');
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