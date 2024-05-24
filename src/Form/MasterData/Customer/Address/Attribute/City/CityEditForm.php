<?php

namespace App\Form\MasterData\Customer\Address\Attribute\City;

use App\Form\MasterData\Customer\Address\Attribute\State\StateAutoCompleteField;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class CityEditForm extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder->add('id', HiddenType::class);
        $builder->add('code',TextType::class);
        $builder->add('name',TextType::class);
        $builder->add('state', StateAutoCompleteField::class);

    }

    public function getBlockPrefix(): string
    {
        return 'city_edit_form';
    }
}