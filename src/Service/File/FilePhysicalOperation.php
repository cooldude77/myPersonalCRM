<?php

namespace App\Service\File;

use App\Form\Common\File\DTO\FileFormDTO;
use App\Form\Common\File\Mapper\FileDTOMapper;
use App\Service\File\Provider\Interfaces\DirectoryPathProviderInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FilePhysicalOperation
{

    public function createOrReplaceFile(UploadedFile $fileHandle,
                                        string       $fileName,
                                        string       $directoryForFileToBeMoved): File
    {
        return $fileHandle->move($directoryForFileToBeMoved, $fileName);
    }


}