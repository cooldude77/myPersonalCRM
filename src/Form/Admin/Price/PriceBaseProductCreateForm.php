<?php

namespace App\Form\Admin\Price;

use App\Form\Admin\Price\DTO\PriceBaseProductDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PriceBaseProductCreateForm extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('productId', TextType::class);
        $builder->add('price', TextType::class);
        $builder->add('currencyId', TextType::class);
        $builder->add('save', SubmitType::class);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => PriceBaseProductDTO::class]);
    }
}