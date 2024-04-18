<?php

namespace App\Tests\Controller\Admin\Product\Category;

use App\Controller\Admin\Product\Category\CategoryController;
use App\Service\Testing\AbstractDoctrineWithMigrationTestCase;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CategoryControllerTest extends AbstractDoctrineWithMigrationTestCase
{

    public function testCreate()
    {
        // This calls KernelTestCase::bootKernel(), and creates a
        // "client" that is acting as the browser
        $client = static::createClient();

        // Request a specific page
        $crawler = $client->request('GET', '/category/create');

        // Validate a successful response and some content
        $this->assertResponseIsSuccessful();
        $buttonCrawlerNode = $crawler->selectButton('Save');

        $form = $buttonCrawlerNode->form();

        $form['category_create_form[name]'] = 'Cat1';
        $form['category_create_form[description]'] = 'Category 1';
        // submit the Form object
        $client->submit($form);
        $this->assertResponseIsSuccessful();

        // Request a specific page
        $crawler = $client->request('GET', '/category/create');

        // Validate a successful response and some content
        $this->assertResponseIsSuccessful();
        $buttonCrawlerNode = $crawler->selectButton('Save');

        $form = $buttonCrawlerNode->form();

        $form['category_create_form[name]'] = 'Cat11';
        $form['category_create_form[description]'] = 'Category 11';
        $form['category_create_form[parent]']->disableValidation()->select("Category 1");

        $domDocument = $crawler->getNode(0)?->parentNode;
             $option = $domDocument->createElement('option');

             $crawler->filter('select')->getNode(0)?->appendChild($option);

        $option->setAttribute('1','Category 1' );

        // submit the Form object
        $client->submit($form);
        $this->assertResponseIsSuccessful();

        
        

    }
}
