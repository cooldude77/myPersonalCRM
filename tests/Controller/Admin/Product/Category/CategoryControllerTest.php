<?php

namespace App\Tests\Controller\Admin\Product\Category;

use App\Controller\Admin\Product\Category\CategoryController;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CategoryControllerTest extends WebTestCase
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
    }
}
