<?php

namespace App\Form\MasterData\Category\File\Form;

use App\Form\Common\File\FileCreateForm;
use App\Form\MasterData\Category\File\DTO\CategoryFileDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryFileCreateForm extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('categoryId', HiddenType::class);
        $builder->add('fileFormDTO',FileCreateForm::class);

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {

            // removing save from the original form so that we don't have two save buttons
            $form = $event->getForm();
            $fileForm = $form->get("fileFormDTO");
            $fileForm->remove("save");
        });
    }



    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class'=>CategoryFileDTO::class]);
    }
}