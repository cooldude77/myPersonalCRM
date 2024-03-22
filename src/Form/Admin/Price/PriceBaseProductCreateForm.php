<?php

namespace App\Form\Admin\Price;

use App\Entity\Currency;
use App\Entity\Product;
use App\Form\Admin\Price\DTO\PriceBaseProductDTO;
use App\Form\Admin\Product\Transformer\ProductToIdTransformer;
use App\Form\Common\Currency\CurrencyToIdTransformer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PriceBaseProductCreateForm extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('productId', EntityType::class,['class'=>Product::class]);
        $builder->add('price', TextType::class);
        $builder->add('currencyId', EntityType::class,['class'=>Currency::class]);
        $builder->add('save', SubmitType::class);

    }
    public function configureOptions(OptionsResolver $resolver)
    {
      $resolver->setDefaults(['data_class'=>PriceBaseProductDTO::class]);
    }
}