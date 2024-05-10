<?php

namespace App\Form\Admin\Product\File\Image\Form;

use App\Entity\ProductImageType;
use App\Form\Admin\Product\File\DTO\ProductFileImageDTO;
use App\Form\Admin\Product\File\Form\ProductFileCreateForm;
use App\Form\Admin\Product\File\Form\ProductFileEditForm;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductImageFileEditForm extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('productFileDTO', ProductFileEditForm::class);

        // Todo: Read Only doesn't work here
        $builder->add('imageType', EntityType::class, ['class' => ProductImageType::class, 'choice_label' => 'description', 'choice_value' => 'id']);

        $builder->add('save', SubmitType::class, array('label' => 'Submit'));

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class'=>ProductFileImageDTO::class]);
    }
}