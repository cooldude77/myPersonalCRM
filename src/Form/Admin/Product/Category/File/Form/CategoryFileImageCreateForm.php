<?php

namespace App\Form\Admin\Product\Category\File\Form;

use App\Entity\CategoryImageType;
use App\Form\Admin\Product\Category\File\DTO\CategoryFileImageDTO;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryFileImageCreateForm extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('categoryFileDTO', CategoryFileCreateForm::class);

        $builder->add('imageType', EntityType::class, ['class' => CategoryImageType::class, 'choice_label' => 'description', 'choice_value' => 'id']);

        $builder->add('save', SubmitType::class, array('label' => 'Submit'));

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class'=>CategoryFileImageDTO::class]);
    }
}