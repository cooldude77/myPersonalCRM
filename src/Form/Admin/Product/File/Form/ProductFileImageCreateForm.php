<?php

namespace App\Form\Admin\Product\File\Form;

use App\Entity\ProductFile;
use App\Form\Common\File\FileCreateForm;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class ProductFileImageCreateForm extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('productFileDTO', ProductFileCreateForm::class);

        $builder->add('productImageTypeId', EntityType::class,
            [
                'class' => \App\Entity\ProductImageType::class,
                'choice_label'=>'description',
                'choice_value'=>'id']);
    }
}