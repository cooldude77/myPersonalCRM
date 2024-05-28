<?php

namespace App\Form\Module\WebShop\External\Address;

use App\Form\MasterData\Customer\Address\CustomerAddressCreateForm;
use App\Form\Module\WebShop\External\Address\DTO\AddressChooseDTO;
use App\Form\Module\WebShop\External\Address\DTO\AddressCreateAndChooseDTO;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressChooseForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('isChosen', CheckboxType::class);
        $builder->add('addressText', TextType::class,['mapped'=>false]);

    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('data_class', AddressChooseDTO::class);

    }

    public function getBlockPrefix()
    {
        return 'address_choose_form';
    }
}