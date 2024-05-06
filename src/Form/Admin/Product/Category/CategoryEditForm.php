<?php

namespace App\Form\Admin\Product\Category;

use App\Form\Admin\Product\Category\DTO\CategoryDTO;
use App\Form\CategoryAutoCompleteField;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryEditForm extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('id',HiddenType::class);
        $builder->add('name', TextType::class,);
        $builder->add('description', TextType::class);

        $builder->add('parent', CategoryAutoCompleteField::class,['required'=>false]);

        $builder->add('save', SubmitType::class);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefault('data_class',CategoryDTO::class);
    }



    public function getBlockPrefix(): string
    {
        return 'category_edit_form';
    }
}