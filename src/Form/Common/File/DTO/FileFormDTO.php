<?php

namespace App\Form\Common\File\DTO;

class FileFormDTO
{
    /** @var string
     * @Assert\NotBlank(message="Please enter name of file")
     */
    public string $name;
    public string $type;

    /**
     * @var mixed
     * @Assert\NotBlank 
     */
    public mixed $uploadedFile;

}