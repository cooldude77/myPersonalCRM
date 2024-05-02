<?php

namespace App\Form\Admin\Product\File\Form;

use App\Entity\ProductImageType;
use App\Form\Admin\Product\File\DTO\ProductFileDTO;
use App\Form\Admin\Product\File\DTO\ProductFileImageDTO;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductFileImageCreateForm extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('productFileDTO', ProductFileCreateForm::class);

        $builder->add('imageType', EntityType::class, ['class' => ProductImageType::class, 'choice_label' => 'description', 'choice_value' => 'id']);

        $builder->add('save', SubmitType::class, array('label' => 'Submit'));

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class'=>ProductFileImageDTO::class]);
    }
}