<?php

namespace App\Form\Common\File;

use App\Form\Common\File\Type\Transformer\FileTypeToIdTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

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

        $builder->add('type', TextType::class, [
            // validation message if the data transformer fails
            'invalid_message' => 'That is not a valid file Type id',
        ])->get('type')
            ->addModelTransformer($this->fileTypeToIdTransformer);


        $builder->add('uploadedFile', FileType::class, [
            'label' => 'File',
            'mapped' => false,
            'required' => false
        ]);

        $builder->add('save', SubmitType::class, array('label' => 'Submit'));

    }
}