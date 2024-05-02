<?php

namespace App\Form\Admin\Product\Type\Attribute;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class ProductTypeAttributeCreateForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('name', TextType::class);
        $builder->add('description', TextType::class);
        $builder->add('valueType', EntityType::class, [
                'class' => 'App\Entity\ProductAttributeType',
                'choice_label' => 'description'
            ]
        );
        $builder->add('save', SubmitType::class);
    }
}