<?php

namespace App\Form\Admin\Product\Category\File\Form;

use App\Form\Admin\Product\Category\File\DTO\CategoryFileDTO;
use App\Form\Common\File\FileCreateForm;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryFileCreateForm extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('categoryId', TextType::class);
        $builder->add('fileFormDTO',FileCreateForm::class);

    }



    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class'=>CategoryFileDTO::class]);
    }
}