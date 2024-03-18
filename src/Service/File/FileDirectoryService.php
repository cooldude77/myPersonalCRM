<?php

namespace App\Service\File;

use App\Kernel;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 *  Directory Structure:
 *
 *  Product: Base Kernel Dir/public/files/products/{id}/{filename.extension}
 */
class FileDirectoryService
{


    /** @var Kernel */
    private KernelInterface $kernel;
    /**
     * @var string
     */
    private string $projectDir;
    private string $fileBaseDirPathSegment = '/public/uploads';

    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;

         $this->projectDir = $this->kernel->getProjectDir();


    }

    public function getProductFileFullPath(int $type,int $id): string
    {
        return $this->projectDir.$this->fileBaseDirPathSegment.'/products/{$id}/';
    }
    public function getGeneralFileFullPath(): string
    {
        return $this->projectDir.$this->fileBaseDirPathSegment.'/general/';
    }

}