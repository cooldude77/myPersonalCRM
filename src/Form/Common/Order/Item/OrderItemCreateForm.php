<?php

namespace App\Form\Common\Order\Item;

use App\Form\Admin\Product\Transformer\ProductToIdTransformer;
use App\Form\Common\Order\Header\Transformer\OrderHeaderToIdTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class OrderItemCreateForm extends AbstractType
{
    private ProductToIdTransformer $productToIdTransformer;
    private OrderHeaderToIdTransformer $orderHeaderToIdTransformer;

    public function __construct(
        ProductToIdTransformer $productToIdTransformer, OrderHeaderToIdTransformer $orderHeaderToIdTransformer
    )
    {

        $this->productToIdTransformer = $productToIdTransformer;
        $this->orderHeaderToIdTransformer = $orderHeaderToIdTransformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('product', TextType::class, [
            // validation message if the data transformer fails
            'invalid_message' => 'That is not a valid product id',
        ])->get('product')
            ->addModelTransformer($this->productToIdTransformer);

        $builder->add('quantity', TextType::class);
        $builder->add('orderHeader', TextType::class, [
            // validation message if the data transformer fails
            'invalid_message' => 'That is not a valid product id',
        ])->get('orderHeader')
            ->addModelTransformer($this->orderHeaderToIdTransformer);

        $builder->add('save', SubmitType::class);

    }
}