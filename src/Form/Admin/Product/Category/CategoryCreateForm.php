<?php

namespace App\Form\Admin\Product\Category;

use App\Form\Admin\Product\Category\Transformer\CategoryToIdTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

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
        $builder->add('code', TextType::class);
        $builder->add('description', TextType::class);
        $builder->add('parent', TextType::class, ['attr' => ['require' => false]])->
        get('parent')->addModelTransformer($this->categoryToIdTransformer);

        $builder->add('save', SubmitType::class);

    }
}