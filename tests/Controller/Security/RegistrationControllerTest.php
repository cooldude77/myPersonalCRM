<?php

namespace App\Tests\Controller\Security;

use App\Factory\CustomerFactory;
use App\Factory\UserFactory;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Browser\Test\HasBrowser;

class RegistrationControllerTest extends WebTestCase
{
    use HasBrowser;

    public function testRegister()
    {
        $createUrl = '/register';


        $this->browser()->visit($createUrl)->fillField(
            'registration_form[login]', 'x@y.com'
        )->fillField(
            'registration_form[plainPassword]', 'fwfwefwefwqwe2234fwf'
        )
            ->fillField('registration_form[agreeTerms]', true)
            ->click('Register')->assertSuccessful();

        $created = UserFactory::find(array('login' => 'x@y.com'));
        $customer = CustomerFactory::find(['user' => $created]);

        $this->assertNotNull($created);
        $this->assertTrue(in_array('ROLE_CUSTOMER', $created->getRoles()));
        $this->assertNotNull($customer);


    }
}
