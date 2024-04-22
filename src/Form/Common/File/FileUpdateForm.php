<?php

namespace App\Form\Common\File;

use App\Form\Common\File\DTO\FileFormDTO;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FileUpdateForm extends
    AbstractType
{
    public function buildForm(FormBuilderInterface $builder,
                              array                $options): void
    {
        $builder->add('id',
            HiddenType::class);

        $builder->add('name',
            TextType::class,
            ['attr' => ['read_only' => true]]);

        $builder->add('yourFileName',
            TextType::class);

        $builder->add('type',
            EntityType::class,
            [// validation message if the data transformer fails
                'invalid_message' => 'That is not a valid file Type id', 'class' => \App\Entity\FileType::class, 'choice_label' => 'description', 'choice_value' => 'id']);

        $builder->add('uploadedFile',
            FileType::class,
            ['label' => 'File', 'required' => false]);

        $builder->addEventListener(FormEvents::PRE_SET_DATA,
            function (FormEvent $event) {

                /** @var FileFormDTO $fileFormDTO */
                $fileFormDTO = $event->getData();

                if ($fileFormDTO->name == null) $fileFormDTO->name = uniqid(rand(),
                    true);

                $event->setData($fileFormDTO);
            });
        $builder->add('save',
            SubmitType::class);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => FileFormDTO::class]);
    }
}