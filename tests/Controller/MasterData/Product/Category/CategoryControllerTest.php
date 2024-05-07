<?php

namespace App\Tests\Controller\MasterData\Product\Category;

use App\Factory\CategoryFactory;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Browser\Test\HasBrowser;

/**
 *  Read boostrap.php comments for additional info
 */
class CategoryControllerTest extends WebTestCase
{

    use HasBrowser;

    /**
     * Requires this test extends Symfony\Bundle\FrameworkBundle\Test\KernelTestCase
     * or Symfony\Bundle\FrameworkBundle\Test\WebTestCase.
     */
    public function testCreateSingleWithoutAParent()
    {

        $uri = '/category/create';
        $this->browser()
            ->visit($uri)
            ->fillField(
                'category_create_form[name]', 'Cat1'
            )
            ->fillField('category_create_form[description]', 'Category 1')
            ->fillField('category_create_form[parent]', "")
            ->click('Save')
            ->assertSuccessful();

        $created = CategoryFactory::find(array('name'=>"Cat1"));

        $this->assertEquals("Cat1", $created->getName());
    }

    public function testCreateWithAParent()
    {

        $uri = '/category/create';

       $category =  CategoryFactory::createOne(['name'=>'CatParent','description'=>'Category Parent']);

        // The value of category->getId() will be  1

        $visit = $this->browser()->visit($uri);

        $crawler = $visit->client()->getCrawler();

        $domDocument = $crawler->getNode(0)?->parentNode;

        $option = $domDocument->createElement('option');
        // don't use static value like 1,2
        $option->setAttribute('value',  $category->getId());
        $selectElement = $crawler->filter('select')->getNode(0);
        $selectElement->appendChild($option);

        $visit->fillField('category_create_form[name]', 'CatChildWithParent')
            ->fillField(
                'category_create_form[description]', 'Category Child With Parent'
            )
            // don't use static value like 1,2
            ->fillField('category_create_form[parent]', $category->getId())
            ->click('Save')
            ->assertSuccessful();

        $created = CategoryFactory::find(array('name'=>"CatChildWithParent"));
        $this->assertEquals("CatChildWithParent", $created->getName());


    }


    /**
     * Requires this test extends Symfony\Bundle\FrameworkBundle\Test\KernelTestCase
     * or Symfony\Bundle\FrameworkBundle\Test\WebTestCase.
     */
    public function testEdit()
    {

        $category = CategoryFactory::createOne(['name'=>'Cat1','description'=>'Category 1']);
        $id = $category->getId();

        $uri = "/category/$id/edit";
        $this->browser()
            ->visit($uri)
            ->fillField('category_edit_form[name]', 'Cat2')
            ->fillField(
                'category_edit_form[description]', 'Category 2'
            )
            ->click('Save')
            ->assertSuccessful();



        $edited = CategoryFactory::find(array('name'=>"Cat2"));
        $this->assertNotNull($edited);
    }

   /**
     * Requires this test extends Symfony\Bundle\FrameworkBundle\Test\KernelTestCase
     * or Symfony\Bundle\FrameworkBundle\Test\WebTestCase.
     */
    public function testDisplay()
    {

        $category = CategoryFactory::createOne(['name'=>'Cat1','description'=>'Category 1']);
        $id = $category->getId();

        $uri = "/category/$id/display";
        $this->browser()
            ->visit($uri)
            ->assertSuccessful();

    }


    public function testList()
    {

        $url = '/category/list';
        $this->browser()->visit($url)->assertSuccessful();

    }


}
