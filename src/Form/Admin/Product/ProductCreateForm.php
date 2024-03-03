<?php

namespace App\Form\Admin\Product;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class ProductCreateForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('productCode', TextType::class);
        $builder->add('productDescription', TextType::class);
        $builder->add('category', TextType::class);
        $builder->add('save', SubmitType::class);

    }
}