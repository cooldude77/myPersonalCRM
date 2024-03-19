<?php

namespace App\Form\Admin\Product\File\Form;

use App\Form\Admin\Product\File\DTO\ProductFileDTO;
use App\Form\Common\File\DTO\FileFormDTO;
use App\Form\Common\File\FileCreateForm;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductFileCreateForm extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('productId', TextType::class);
        $builder->add('fileFormDTO',FileCreateForm::class);

    }



    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class'=>ProductFileDTO::class]);
    }
}