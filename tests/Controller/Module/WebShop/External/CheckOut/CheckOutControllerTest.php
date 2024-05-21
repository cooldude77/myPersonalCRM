<?php

namespace App\Tests\Controller\Module\WebShop\External\CheckOut;

use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Browser\Test\HasBrowser;

class CheckOutControllerTest extends WebTestCase
{
    use HasBrowser;

    public function testCheckout()
    {
        $uri = "/checkout";
        $this->browser()->visit($uri)->assertSuccessful();
    }
}
