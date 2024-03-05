<?php

namespace App\Form\Admin\Price;

use App\Form\Admin\Product\Transformer\ProductToIdTransformer;
use App\Form\Common\Currency\CurrencyToIdTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class PriceBaseProductCreateForm extends AbstractType
{

    private CurrencyToIdTransformer $currencyToIdTransformer;
    private ProductToIdTransformer $productToIdTransformer;

    public function __construct(
        ProductToIdTransformer  $productToIdTransformer,
        CurrencyToIdTransformer $currencyToIdTransformer)
    {

        $this->productToIdTransformer = $productToIdTransformer;
        $this->currencyToIdTransformer = $currencyToIdTransformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('product', TextType::class);
        $builder->add('price', TextType::class);
        $builder->add('currency', TextType::class);
        $builder->add('save', SubmitType::class);
        $builder->get('product')
            ->addModelTransformer($this->productToIdTransformer);

        $builder->get('currency')
            ->addModelTransformer($this->currencyToIdTransformer);

    }
}