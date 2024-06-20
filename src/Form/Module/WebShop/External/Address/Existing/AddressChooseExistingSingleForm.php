<?php

namespace App\Form\Module\WebShop\External\Address\Existing;

use App\Form\Module\WebShop\External\Address\Existing\DTO\AddressChooseExistingSingleDTO;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressChooseExistingSingleForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('isChosen', CheckboxType::class);
        $builder->add('addressText', TextType::class,['mapped'=>false]);

    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('data_class', AddressChooseExistingSingleDTO::class);

    }

    public function getBlockPrefix()
    {
        return 'address_choose_existing_single_form';
    }
}