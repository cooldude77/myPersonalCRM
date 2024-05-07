<?php

namespace App\Form\MasterData\Customer\Address;

use App\Form\MasterData\Address\AddressCreateForm;
use App\Form\MasterData\Customer\Address\DTO\AddressDTO;
use App\Form\MasterData\Customer\Address\DTO\CustomerAddressDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CustomerAddressEditForm extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('address', AddressCreateForm::class);
        $builder->add('save', SubmitType::class);

        $builder->add('save', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => CustomerAddressDTO::class]);
    }

    public function getBlockPrefix(): string
    {
        return '_customerAddress_edit_form';
    }
}