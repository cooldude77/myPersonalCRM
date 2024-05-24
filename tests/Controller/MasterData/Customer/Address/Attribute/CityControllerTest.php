<?php

namespace App\Tests\Controller\MasterData\Customer\Address\Attribute;

use App\Factory\CityFactory;
use App\Tests\Fixtures\LocationFixture;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DomCrawler\Crawler;
use Zenstruck\Browser;
use Zenstruck\Browser\Test\HasBrowser;

class CityControllerTest extends TestCase
{

    use HasBrowser, LocationFixture;

    /**
     * Requires this test extends Symfony\Bundle\FrameworkBundle\Test\KernelTestCase
     * or Symfony\Bundle\FrameworkBundle\Test\WebTestCase.
     */
    public function testCreate()
    {
        $createUrl = '/city/create';

        $this->createLocationFixtures();

        $visit = $this->browser()->visit($createUrl)
            ->fillField(
                'city_create_form[code]', 'DL'
            )->fillField(
                'city_create_form[name]', 'New Delhi'
            )->fillField('city_create_form[stateId]', $this->state->getId())
            ->click('Save')
            ->use(function (Browser $browser, Crawler $crawler) {
                $domDocument = $crawler->getNode(0)?->parentNode;

                $option = $domDocument->createElement('option');
                $option->setAttribute('value', $this->state->getId());
                $selectElement = $crawler->filter('select')->getNode(0);
                $selectElement->appendChild($option);

            })
            ->assertSuccessful();

        $created = CityFactory::find(array('code' => 'DL'));

        $this->assertEquals("New Delhi", $created->getName());


    }

    /**
     * Requires this test extends Symfony\Bundle\FrameworkBundle\Test\KernelTestCase
     * or Symfony\Bundle\FrameworkBundle\Test\WebTestCase.
     */
    public function testDisplay()
    {

        $this->createLocationFixtures();

        $id = $this->city->getId();
        $url = "/city/$id/display";

        $this->browser()->visit($url)->assertSuccessful();


    }


    public function testList()
    {
        $this->createLocationFixtures();
        $url = '/city/list';
        $this->browser()->visit($url)->assertSuccessful();

    }

}
