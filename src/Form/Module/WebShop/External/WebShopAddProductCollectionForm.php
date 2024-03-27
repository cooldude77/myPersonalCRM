<?php

namespace App\Form\Module\WebShop\External;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class WebShopAddProductCollectionForm extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder,
                              array                $options): void
    {
        $builder->add('products',
            CollectionType::class,
            ['entry_type' => WebShopAddProductSingleForm::class]);

        $builder->add('update', SubmitType::class,['label'=>'Update Cart']);

        $builder->add('cart',SubmitType::class,['label'=>'Goto Cart']);
    }

}