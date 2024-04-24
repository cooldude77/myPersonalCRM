<?php

namespace App\Form\Admin\Product\Category\File\Form;

use App\Form\Admin\Product\Category\File\DTO\CategoryFileDTO;
use App\Form\Common\File\DTO\FileFormDTO;
use App\Form\Common\File\FileCreateForm;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryFileCreateForm extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('categoryId', HiddenType::class);
        $builder->add('fileFormDTO',FileCreateForm::class);

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {

            // removing save from the original form so that we don't have two save buttons
            $form = $event->getForm();
            $fileForm = $form->get("fileFormDTO");
            $fileForm->remove("save");
        });
        ;
    }



    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class'=>CategoryFileDTO::class]);
    }
}