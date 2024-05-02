<?php

namespace App\Form\Admin\Price\Tax;

use App\Form\Admin\Product\Transformer\ProductToIdTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class TaxProductCreateForm extends AbstractType
{

    private ProductToIdTransformer $productToIdTransformer;

    public function __construct(
        ProductToIdTransformer $productToIdTransformer,
    )
    {

        $this->productToIdTransformer = $productToIdTransformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('product', TextType::class);
        $builder->add('taxRate', TextType::class);
        $builder->add('save', SubmitType::class);
        $builder->get('product')
            ->addModelTransformer($this->productToIdTransformer);


    }
}