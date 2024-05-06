<?php

namespace App\Form\Admin\Product;

use App\Form\Admin\Product\Attribute\DTO\ProductAttributeDTO;
use App\Form\Admin\Product\DTO\ProductDTO;
use App\Form\CategoryAutoCompleteField;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductEditForm extends AbstractType
{

    // If one uses model transformer then only category id is provided in controller
    // instead, do not use it. You get a category entity object in mapper directly

   function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('name', TextType::class);
        $builder->add('description', TextType::class);
        $builder->add('category', CategoryAutoCompleteField::class,['required'=>false]);
        $builder->add('isActive', CheckboxType::class);

        $builder->add('save', SubmitType::class);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => ProductDTO::class]);
    }


    public function getBlockPrefix(): string
    {
        return 'product_edit_form';
    }
}