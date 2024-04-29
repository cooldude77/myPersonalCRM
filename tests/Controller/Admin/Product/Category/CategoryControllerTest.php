<?php

namespace App\Tests\Controller\Admin\Product\Category;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Browser\Test\HasBrowser;

class CategoryControllerTest extends WebTestCase
{

    use HasBrowser;
    /**
     * Requires this test extends Symfony\Bundle\FrameworkBundle\Test\KernelTestCase
     * or Symfony\Bundle\FrameworkBundle\Test\WebTestCase.
     */
    public function test_using_kernel_browser(): void
    {

        $this->browser()
            ->visit('/category/create')
            ->assertStatus(200)
            ->assertSuccessful();
    }
    public function testCreate()
    {

        $this->browser()
            ->visit('/category/create')
            ->fillField('category_create_form[name]', 'Cat1')
            ->fillField('category_create_form[description]','Category 1')
            ->fillField('category_create_form[parent]',"")
            ->click('Save')
            ->assertSuccessful();
       

    }
}
