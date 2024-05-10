<?php

namespace App\Form\MasterData\Category\File\Image\Form;

use App\Form\Common\File\FileEditForm;
use App\Form\MasterData\Category\File\DTO\CategoryImageDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryImageEditForm extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('fileFormDTO', FileEditForm::class);

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {

            // removing save from the original form so that we don't have two save buttons
            $form = $event->getForm();
            $fileForm = $form->get("fileFormDTO");
            $fileForm->remove("save");
        });
        $builder->add('save', SubmitType::class, array('label' => 'Submit'));

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => CategoryImageDTO::class]);
    }
}