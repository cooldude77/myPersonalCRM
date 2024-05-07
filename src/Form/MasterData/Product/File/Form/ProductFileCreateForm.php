<?php

namespace App\Form\MasterData\Product\File\Form;

use App\Form\Common\File\FileCreateForm;
use App\Form\MasterData\Product\File\DTO\ProductFileDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductFileCreateForm extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('productId', TextType::class);
        $builder->add('fileFormDTO',FileCreateForm::class);

    }



    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class'=>ProductFileDTO::class]);
    }
}