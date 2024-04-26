<?php

namespace App\Form\Admin\Product\Category\File\Image\Form;

use App\Entity\CategoryImageType;
use App\Form\Admin\Product\Category\File\DTO\CategoryFileImageDTO;
use App\Form\Admin\Product\Category\File\Form\CategoryFileCreateForm;
use App\Form\Admin\Product\Category\File\Form\CategoryFileEditForm;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryImageFileEditForm extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('categoryFileDTO', CategoryFileEditForm::class);

        // Todo: Read Only doesn't work here
        $builder->add('imageType', EntityType::class, ['class' => CategoryImageType::class, 'choice_label' => 'description', 'choice_value' => 'id']);

        $builder->add('save', SubmitType::class, array('label' => 'Submit'));

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class'=>CategoryFileImageDTO::class]);
    }
}