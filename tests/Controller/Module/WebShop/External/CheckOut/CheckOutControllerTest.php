<?php

namespace App\Tests\Controller\Module\WebShop\External\CheckOut;

use App\Factory\CustomerFactory;
use App\Factory\UserFactory;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Browser;
use Zenstruck\Browser\Test\HasBrowser;

class CheckOutControllerTest extends WebTestCase
{
    use HasBrowser;

    public function testCheckoutWhenNotLoggedIn()
    {
        $uri = "/checkout";
        $this
            ->browser()
            ->visit($uri)
            ->assertNotAuthenticated()
            ->assertSee('Login')
            ->assertSee('Sign Up To Proceed');
    }

    public function testCheckoutWhenLoggedIn()
    {
        $user = UserFactory::createOne(['login'=>'a@b.com']);

        $customer = CustomerFactory::createOne(['user' => $user]);


        $uri = "/checkout";
        $this->browser()
            ->use(function (Browser $browser) use ($user) {
                $browser->client()->loginUser($user->object());
            })
            ->visit($uri)
            ->assertSee('Create Shipping Address')
            ->assertSee('Create Billing Address');
    }
}
