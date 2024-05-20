<?php

namespace App\Tests\Controller\Security\Customer;

use App\Factory\CustomerFactory;
use App\Factory\UserFactory;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Browser\Test\HasBrowser;

class CustomerSignUpControllerTest extends WebTestCase
{
    use HasBrowser;

    public function testSignUp()
    {
        $uri = '/signup';


        $this->browser()
            // use before visiting
            ->interceptRedirects()
            ->visit($uri)->fillField(
                'sign_up_form[login]', 'x@y.com'
            )->fillField(
                'sign_up_form[plainPassword]', 'fwfwefwefwqwe2234fwf'
            )
            ->fillField('sign_up_form[agreeTerms]', true)
            ->click('Sign Up')
            // assert on same Uri, or redirect check will fail
            ->assertOn($uri)
            ->assertRedirected();

        $created = UserFactory::find(array('login' => 'x@y.com'));
        $customer = CustomerFactory::find(['user' => $created]);

        $this->assertNotNull($created);
        $this->assertTrue(in_array('ROLE_CUSTOMER', $created->getRoles()));
        $this->assertNotNull($customer);


    }

    public function testSignUpAdvanced()
    {
        $createUrl = '/signup/advanced?_redirect_after_success=/';
        $this->browser()->visit($createUrl)->fillField(
            'customer_create_form[firstName]', 'First Name'
        )->fillField(
            'customer_create_form[lastName]', 'Last Name'
        )->fillField('customer_create_form[email]', 'x@y.com')
            ->fillField('customer_create_form[phoneNumber]', '+91999999999')
            ->fillField('customer_create_form[plainPassword]', '4534geget355$%^')
            ->click('Save')
            ->assertSuccessful();

        $created = CustomerFactory::find(array('firstName' => 'First Name'));

        $this->assertEquals("First Name", $created->getFirstName());

        $created = UserFactory::find(array('login' => 'x@y.com'));
        $customer = CustomerFactory::find(['user' => $created]);

        $this->assertNotNull($created);
        $this->assertTrue(in_array('ROLE_CUSTOMER', $created->getRoles()));
        $this->assertNotNull($customer);


    }
}
