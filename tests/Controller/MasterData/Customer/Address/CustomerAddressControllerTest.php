<?php

namespace App\Tests\Controller\MasterData\Customer\Address;

use App\Factory\CustomerAddressFactory;
use App\Factory\CustomerFactory;
use App\Tests\Fixtures\LocationFixture;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Browser\Test\HasBrowser;

class CustomerAddressControllerTest extends WebTestCase
{

    use HasBrowser;
    use LocationFixture;

    public function testCreate()
    {

        $this->createLocationFixtures();

        $customer = CustomerFactory::createOne();
        $id = $customer->getId();

        $uri = "/customer/{$id}/address/create";
        $this->browser()
            ->visit($uri)
            ->fillField(
                'customer_address_create_form[line1]', 'Line 1'
            )
            ->click('Save')
            ->assertSuccessful();

        $created = CustomerAddressFactory::find(array('line1' => 'Line 1'));

        $this->assertEquals('Line 1', $created->getLine1());

    }


    public function testEdit()
    {

        $this->createLocationFixtures();

        $customer = CustomerFactory::createOne();
        $customerAddress = CustomerAddressFactory::createOne(['customer' => $customer]);

        $id = $customerAddress->getId();

        $uri = "/customer/address/{$id}/edit";
        $this->browser()
            ->visit($uri)
            ->fillField(
                'customer_address_edit_form[line1]', 'Line 11'
            )
            ->click('Save')
            ->assertSuccessful();

        $created = CustomerAddressFactory::find(array('line1' => "Line 11"));

        $this->assertEquals('Line 11', $created->getLine1());
    }

    public function testList()
    {
        $customer = CustomerFactory::createOne();
        CustomerAddressFactory::createMany(10, ['customer' => $customer]);

        $id = $customer->getId();
        $url = "/customer/{$id}/address/list";
        $this->browser()->visit($url)->assertSuccessful();

    }

}