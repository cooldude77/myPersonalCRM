<?php

namespace App\Form\Module\WebShop\External\CheckOut\Address;

use App\Form\Module\WebShop\External\CheckOut\Address\DTO\AddressDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressSingle extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder->add('id', HiddenType::class);
        $builder->add('addressChoice', ChoiceType::class, ['multiple' => false,
                                                           'expanded' => true,
                                                           'mapped' => false]);

    }

    public function configureOptions(OptionsResolver $resolver):void
    {
        $resolver->setDefaults(['data_class' => AddressDTO::class]);

    }
}