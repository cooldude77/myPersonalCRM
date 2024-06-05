<?php

namespace App\Tests\Controller\Security\External\Credentials;

use App\Factory\CustomerFactory;
use App\Factory\SalutationFactory;
use App\Factory\UserFactory;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DomCrawler\Crawler;
use Zenstruck\Browser;
use Zenstruck\Browser\Test\HasBrowser;

class SignUpControllerTest extends WebTestCase
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
        $createUrl = '/signup/advanced?_redirect_after_success=home';


        $salutation = SalutationFactory::createOne(['name' => 'Mr.',
                                                    'description' => 'Mister...']);

        $this->browser()->visit($createUrl)
            ->use(function (Browser $browser, Crawler $crawler) use ($salutation) {

                $domDocument = $crawler->getNode(0)?->parentNode;

                $option = $domDocument->createElement('option');
                $option->setAttribute('value', $salutation->getId());
                $selectElement = $crawler->filter('select')->getNode(0);
                $selectElement->appendChild($option);
            })
            ->fillField(
                'user_sign_up_advanced_form[firstName]', 'First Name'
            )->fillField(
                'user_sign_up_advanced_form[lastName]', 'Last Name'
            )->fillField('user_sign_up_advanced_form[email]', 'x@y.com')
            ->fillField('user_sign_up_advanced_form[phoneNumber]', '+91999999999')
            ->fillField('user_sign_up_advanced_form[plainPassword]', '4534geget355$%^')
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
