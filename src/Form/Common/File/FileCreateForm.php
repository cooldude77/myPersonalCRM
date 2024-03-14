<?php

namespace App\Form\Common\File;

use App\Entity\File;
use App\Form\Common\File\Type\Transformer\FileTypeToIdTransformer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\ChoiceList;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class FileCreateForm extends AbstractType
{

    private FileTypeToIdTransformer $fileTypeToIdTransformer;

    public function __construct(
        FileTypeToIdTransformer $fileTypeToIdTransformer,
    )
    {

        $this->fileTypeToIdTransformer = $fileTypeToIdTransformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class);

        $builder->add('type',  EntityType::class, [
            // validation message if the data transformer fails
            'invalid_message' => 'That is not a valid file Type id',
            'class'=> \App\Entity\FileType::class

        ]);


        $builder->add('uploadedFile', FileType::class, [
            'label' => 'File',
            'mapped' => false,
            'required' => false
        ]);

        $builder->add('save', SubmitType::class, array('label' => 'Submit'));

        $builder->addEventListener(FormEvents::PRE_SET_DATA,function (FormEvent $event){

            /** @var File $file */
            $file = $event->getData();

            if($file->getName() == null)
                $file->setName(uniqid());
        });

    }
}