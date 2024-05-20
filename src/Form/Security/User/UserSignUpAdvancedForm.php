<?php

namespace App\Form\Security\User;

use App\Form\MasterData\Customer\CustomerCreateForm;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Functions are similar so for now  using the customer form
 */
class UserSignUpAdvancedForm extends CustomerCreateForm
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options); // TODO: Change the autogenerated stub
        $builder->remove('middleName');
        $builder->remove('givenName');
        $builder->get('save')->setAttribute('label',"Sign In");


    }

    public function getBlockPrefix(): string
    {
        return 'user_sign_in_advanced_form';
    }
}