<?php

namespace App\Form\Module\WebShop\External\ShopHome;

use App\Form\Module\WebShop\External\ShopHome\DTO\WebShopProductDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WebShopAddProductSingleForm extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder,
        array $options
    ): void {
        $builder->add(
            'productId',
            NumberType::class, ['label' => false]
        );
        $builder->add(
            'quantity',
            NumberType::class, ['label' => false]
        );
        $builder->add(
            'addToCart',

            SubmitType::class, ['label' => 'Add To Cart']
        );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => WebShopProductDTO::class]);
    }

}