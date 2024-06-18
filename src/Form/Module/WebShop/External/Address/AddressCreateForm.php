<?php

namespace App\Form\Module\WebShop\External\Address;

use App\Form\MasterData\Customer\Address\CustomerAddressCreateForm;
use App\Form\Module\WebShop\External\Address\DTO\AddressCreateAndChooseDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressCreateForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('address', CustomerAddressCreateForm::class);
        $builder->add('isChosen', CheckboxType::class);
        $builder->add('save', SubmitType::class);

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $event->getForm()->get('address')->remove('save');

        });

    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('data_class', AddressCreateAndChooseDTO::class);

    }

    public function getBlockPrefix()
    {
        return 'address_create_and_choose_form';
    }
}