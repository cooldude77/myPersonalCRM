<?php

namespace App\Form\MasterData\Category;

use App\Form\CategoryAutoCompleteField;
use App\Form\MasterData\Category\DTO\CategoryDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryCreateForm extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('name', TextType::class,
        );
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
        return 'category_create_form';
    }
}