<?php

namespace App\Tests\Controller\Security\Customer;

use App\Factory\CustomerFactory;
use App\Factory\UserFactory;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Browser\Test\HasBrowser;

class CustomerSignUpControllerTest extends WebTestCase
{
    use HasBrowser;

    public function testRegister()
    {
        $createUrl = '/signup';


        $this->browser()->visit($createUrl)->fillField(
            'sign_up_form[login]', 'x@y.com'
        )->fillField(
            'sign_up_form[plainPassword]', 'fwfwefwefwqwe2234fwf'
        )
            ->fillField('sign_up_form[agreeTerms]', true)
            ->click('Register')->assertSuccessful();

        $created = UserFactory::find(array('login' => 'x@y.com'));
        $customer = CustomerFactory::find(['user' => $created]);

        $this->assertNotNull($created);
        $this->assertTrue(in_array('ROLE_CUSTOMER', $created->getRoles()));
        $this->assertNotNull($customer);


    }
}
