<?php

namespace App\Form\Common\Order\Header;

use App\Form\Admin\Customer\Transformer\CustomerToIdTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class OrderHeaderCreateForm extends AbstractType
{
    private CustomerToIdTransformer $customerToIdTransformer;

    public function __construct(
        CustomerToIdTransformer $customerToIdTransformer,
    )
    {

        $this->customerToIdTransformer = $customerToIdTransformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('dateTimeOfOrder', DateType::class);
        $builder->add('customer', TextType::class, [
            // validation message if the data transformer fails
            'invalid_message' => 'That is not a valid customer id',
        ])->get('customer')
            ->addModelTransformer($this->customerToIdTransformer);

        $builder->add('save', SubmitType::class);
    }
}