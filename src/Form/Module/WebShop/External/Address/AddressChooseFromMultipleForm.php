<?php

namespace App\Form\Module\WebShop\External\Address;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;

class AddressChooseFromMultipleForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(
            'addresses', CollectionType::class,
            ['entry_type' => AddressChooseForm::class]
        );

    }

}