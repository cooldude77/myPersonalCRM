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
        $form['category_create_form[code]'] = 'Fabien';
        $form['category_create_form[description]'] = 'Symfony rocks!';

        // submit the Form object
        $client->submit($form);
        $this->assertResponseIsSuccessful();

    }
}
