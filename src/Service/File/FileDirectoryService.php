<?php

namespace App\Service\File;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;

/**
 *  Directory Structure:
 *
 *  Product: Base Kernel Dir/public/files/products/{id}/{filename.extension}
 */
class FileDirectoryService
{


    /** @var ParameterBag  */
    private ParameterBag $parameterBag;

    public function __construct(ParameterBag $parameterBag)
    {

        $this->parameterBag = $parameterBag;
    }

    public function getProductFileFullPath(int $type,int $id): string
    {
        return $this->parameterBag->get('kernel.dir').'/public'.'/files/products/{$id}/';
    }
}