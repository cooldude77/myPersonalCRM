<?php

namespace App\Tests\Controller\Common\Admin\PaymentType;

use App\Controller\Common\Admin\PaymentType\PaymentTypeController;
use App\Factory\CategoryFactory;
use App\Factory\PaymentTypeFactory;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Browser\Test\HasBrowser;

class PaymentTypeControllerTest  extends WebTestCase
{

    use HasBrowser;

    /**
     * Requires this test extends Symfony\Bundle\FrameworkBundle\Test\KernelTestCase
     * or Symfony\Bundle\FrameworkBundle\Test\WebTestCase.
     */
    public function testCreate()
    {
       $createUrl = '/payment_type/create';

        $visit = $this->browser()->visit($createUrl);

        $crawler = $visit->client()->getCrawler();

        $domDocument = $crawler->getNode(0)?->parentNode;


        $visit->fillField('payment_type_create_form[name]', 'Prod1')->fillField(
            'payment_type_create_form[description]', 'PaymentType 1'
        )->click('Save')->assertSuccessful();

        $created = PaymentTypeFactory::find(array('name' => "Prod1"));

        $this->assertEquals("Prod1", $created->getName());


    }

    /**
     * Requires this test extends Symfony\Bundle\FrameworkBundle\Test\KernelTestCase
     * or Symfony\Bundle\FrameworkBundle\Test\WebTestCase.
     */
    public function testEdit()
    {
        $product = PaymentTypeFactory::createOne();

        $id = $product->getId();

        $url = "/payment_type/$id/edit";

        $visit = $this->browser()->visit($url)
            ->fillField('payment_type_edit_form[name]', 'Prod1')
            ->fillField(
                'payment_type_edit_form[description]', 'PaymentType 1'
            )
            ->click('Save')
            ->assertSuccessful();

        $created = PaymentTypeFactory::find(array('name' => "Prod1"));

        $this->assertEquals("Prod1", $created->getName());


    }

    /**
     * Requires this test extends Symfony\Bundle\FrameworkBundle\Test\KernelTestCase
     * or Symfony\Bundle\FrameworkBundle\Test\WebTestCase.
     */
    public function testDisplay()
    {
        $category = CategoryFactory::createOne(['name' => 'Cat1',
                                                'description' => 'Category 1']);


        $product = PaymentTypeFactory::createOne();

        $id = $product->getId();
        $createUrl = "/payment_type/$id/display";

        $this->browser()->visit($createUrl)->assertSuccessful();


    }


    public function testList()
    {

        $url = '/payment_type/list';
        $this->browser()->visit($url)->assertSuccessful();

    }


}
