<?php

namespace App\Service\File;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

/**
 *  Directory Structure:
 *
 *  Product: Base Kernel Dir/public/files/products/{id}/{filename.extension}
 */
class FileDirectoryService
{


    /** @var ParameterBag  */
    private ParameterBagInterface $parameterBag;

    public function __construct(ParameterBagInterface $parameterBag)
    {

        $this->parameterBag = $parameterBag;
    }

    public function getProductFileFullPath(int $type,int $id): string
    {
        return $this->parameterBag->get('kernel.dir').'/public'.'/files/products/{$id}/';
    }
    public function getGeneralFileFullPath(): string
    {
        return $this->parameterBag->get('kernel.dir').'/public'.'/files/general/';
    }

}