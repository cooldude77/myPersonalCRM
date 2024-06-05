<?php

namespace App\Tests\Controller\Security\External\Credentials;

use App\Factory\CustomerFactory;
use App\Factory\EmployeeFactory;
use App\Factory\UserFactory;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Browser\Test\HasBrowser;

class LoginManagementControllerTest extends WebTestCase
{
    use HasBrowser;

    // password is converted into code in UserFactory method
    private string $password = 'XYZ123';

    /**
     * @return void
     */
    public function testLoginAsCustomer()
    {
        $user = UserFactory::createOne(['login' => 'x@y.com', 'password' => $this->password]);
        CustomerFactory::createOne(['user' => $user]);

        $uri = '/login';
        // user with customer
        $this->browser()->visit($uri)
            ->fillField(
                '_username', $user->getLogin()
            )->fillField(
                '_password', $this->password
            )
            ->interceptRedirects()
            ->click('login')
            ->assertRedirectedTo('/')
            ->assertAuthenticated();
    }

    public function testLoginAsEmployee()
    {
        $user = UserFactory::createOne(['login' => 'x@y.com', 'password' => $this->password]);
        EmployeeFactory::createOne(['user' => $user]);

        $uri = '/login';
        // user with customer
        $this->browser()->visit($uri)
            ->fillField(
                '_username', $user->getLogin()
            )->fillField(
                '_password', $this->password
            )
            ->interceptRedirects()
            ->click('login')
            ->assertRedirectedTo('/admin')
            ->assertAuthenticated();
    }

    public function testLoginWrongPassword()
    {
        $user = UserFactory::createOne(['login' => 'x@y.com', 'password' => $this->password]);
        CustomerFactory::createOne(['user' => $user]);

        $uri = '/login';
        // user with customer
        $this->browser()->visit($uri)
            ->fillField(
                '_username', $this->password
            )->fillField(
                '_password', 'Wrong Password'
            )
            ->interceptRedirects()
            ->click('login')
            ->assertNotAuthenticated();
    }

    public function testCustomerLogout()
    {

        $user = UserFactory::createOne(['login' => 'x@y.com', 'password' => $this->password]);
        CustomerFactory::createOne(['user' => $user]);

        $uri = '/login';


        $this->browser()->visit($uri)
            ->fillField(
                '_username', $user->getLogin()
            )->fillField(
                '_password', $this->password
            )
            ->click('login')
            ->interceptRedirects()
            ->visit('/logout')
            ->assertRedirectedTo('/');
    }

    public function testEmployeeLogout()
    {

        $user = UserFactory::createOne(['login' => 'x@y.com', 'password' => $this->password]);
        EmployeeFactory::createOne(['user' => $user]);

        $uri = '/login';


        $this->browser()->visit($uri)
            ->fillField(
                '_username', $user->getLogin()
            )->fillField(
                '_password', $this->password
            )
            ->click('login')
            ->interceptRedirects()
            ->visit('/logout')
            ->assertRedirectedTo('/');
    }
}