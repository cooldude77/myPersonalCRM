<?php

namespace App\Form\Admin\Product;

use App\Form\Admin\Product\Category\Transformer\CategoryToIdTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class ProductCreateForm extends AbstractType
{
    private CategoryToIdTransformer $categoryToIdTransformer;

    public function __construct(
        CategoryToIdTransformer $categoryToIdTransformer)
    {

        $this->categoryToIdTransformer = $categoryToIdTransformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('productCode', TextType::class);
        $builder->add('productDescription', TextType::class);
        $builder->add('category', TextType::class);

        $builder->get('category')->addModelTransformer($this->categoryToIdTransformer);

        $builder->add('save', SubmitType::class);

    }
}