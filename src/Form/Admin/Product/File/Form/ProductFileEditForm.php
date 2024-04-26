<?php

namespace App\Form\Admin\Product\File\Form;

use App\Form\Admin\Product\File\DTO\ProductFileDTO;
use App\Form\Common\File\FileCreateForm;
use App\Form\Common\File\FileEditForm;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductFileEditForm extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('productId', HiddenType::class);
        $builder->add('fileFormDTO',FileEditForm::class);

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
        $resolver->setDefaults(['data_class'=>ProductFileDTO::class]);
    }
}