<?php

namespace App\Form\MasterData\Price;

use App\Form\MasterData\Currency\CurrencyAutoCompleteField;
use App\Form\MasterData\Price\DTO\PriceProductBaseDTO;
use App\Form\MasterData\Product\ProductAutoCompleteField;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PriceProductBaseEditForm extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('productId', ProductAutoCompleteField::class);
        $builder->add('price', NumberType::class);
        $builder->add('currencyId', CurrencyAutoCompleteField::class);
        $builder->add('save', SubmitType::class);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => PriceProductBaseDTO::class]);
    }

    public function getBlockPrefix(): string
    {

        return 'price_product_base_edit_form';
    }
}