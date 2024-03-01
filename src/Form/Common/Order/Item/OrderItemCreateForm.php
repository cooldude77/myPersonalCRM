<?php

namespace App\Form\Common\Order\Item;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class OrderItemCreateForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('product', TextType::class);
        $builder->add('quantity', TextType::class);
        $builder->add('save', SubmitType::class);

    }
}