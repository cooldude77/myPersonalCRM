<?php

namespace App\Form\Admin\Product\Category;

use App\Form\Admin\Product\Category\DTO\CategoryDTO;
use App\Form\Admin\Product\Category\Transformer\CategoryToIdTransformer;
use App\Form\CategoryParentAutoCompleteField;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryCreateForm extends AbstractType
{

    private CategoryToIdTransformer $categoryToIdTransformer;

    public function __construct(
        CategoryToIdTransformer $categoryToIdTransformer)
    {

        $this->categoryToIdTransformer = $categoryToIdTransformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class,
        );
        $builder->add('description', TextType::class);
     //   $builder->add('parent', TextType::class, ['required' => false])->
       // get('parent')->addModelTransformer($this->categoryToIdTransformer);
$builder->add('parent', CategoryParentAutoCompleteField::class,['required'=>false]);


        $builder->add('save', SubmitType::class);

    }
    public function configureOptions(OptionsResolver $resolver)
    {
   $resolver->setDefault('data_class',CategoryDTO::class);
    }
}