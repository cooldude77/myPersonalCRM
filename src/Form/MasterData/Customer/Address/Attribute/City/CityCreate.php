<?php

namespace App\Form\MasterData\Customer\Address\Attribute\City;

use App\Form\MasterData\Customer\Address\Attribute\Country\CountryAutoCompleteField;
use App\Form\MasterData\Customer\Address\Attribute\State\StateAutoCompleteField;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class CityCreate extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options):void
    {

        $builder->add('code',TextType::class);
        $builder->add('name',TextType::class);
        $builder->add('stateId', StateAutoCompleteField::class);

    }

    public function getBlockPrefix():string
    {
        return 'city_create_form';
    }
}