<?php

namespace App\Tests\Controller\Security\Admin\User;

use App\Factory\CustomerFactory;
use App\Factory\UserFactory;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Browser\Test\HasBrowser;

class UserControllerTest extends WebTestCase
{
    use HasBrowser;

    public function testLogin()
    {
        $user = UserFactory::createOne(['login' => 'x@y.com', 'password' => 'XYZ123']);
        $customer = CustomerFactory::createOne(['user' => $user]);

        $uri = '/login';


        $browser = $this->browser()->visit($uri)
            ->fillField(
                '_username', $user->getLogin()
            )->fillField(
                '_password', $user->getPassword()
            )
            ->click('login')
            ->assertSuccessful();


        // todo: login with a wrong id or password
    }

    public function testLogout()
    {

        $user = UserFactory::createOne(['login' => 'x@y.com', 'password' => 'XYZ123']);
        $customer = CustomerFactory::createOne(['user' => $user]);

        $uri = '/login';


        $this->browser()->visit($uri)
            ->fillField(
                '_username', $user->getLogin()
            )->fillField(
                '_password', $user->getPassword()
            )
            ->click('login')
            ->visit('/logout')
            ->assertSuccessful();
    }

}
