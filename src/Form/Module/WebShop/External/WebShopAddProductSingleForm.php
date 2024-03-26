<?php

namespace App\Form\Module\WebShop\External;

use App\Form\Module\WebShop\External\DTO\WebShopAddProductDTO;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WebShopAddProductSingleForm extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder,
                              array                $options): void
    {
        $builder->add('productId',
            TextType::class,['label'=>false]);
        $builder->add('quantity',
            NumberType::class,['label'=>false]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
      $resolver->setDefaults(['data_class'=>WebShopAddProductDTO::class]);
    }

}