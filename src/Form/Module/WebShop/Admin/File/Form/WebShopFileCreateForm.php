<?php

namespace App\Form\Module\WebShop\Admin\File\Form;

use App\Form\Module\WebShop\Admin\File\DTO\WebShopFileDTO;
use App\Form\Common\File\DTO\FileFormDTO;
use App\Form\Common\File\FileCreateForm;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WebShopFileCreateForm extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('webShopId', TextType::class);
        $builder->add('fileFormDTO',FileCreateForm::class);

    }



    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class'=>WebShopFileDTO::class]);
    }
}