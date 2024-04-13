<?php

namespace App\Service\File\Base;

use App\Kernel;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpKernel\KernelInterface;

define('DS', DIRECTORY_SEPARATOR);

class AbstractFileDirectoryPathNamer
{
    /** @var Kernel */
    private KernelInterface $kernel;
    /**
     * @var string
     */
    private string $projectDir;
    private string $baseFilePathSegment;

    private string $uploadsSegment ='/uploads';

    public function __construct(KernelInterface $kernel,  #[Autowire(param: 'file_storage_path')]
    string $fileStoragePathFromParameter)
    {
        $this->kernel = $kernel;

        $this->projectDir = $this->kernel->getProjectDir();

        $this->baseFilePathSegment = $fileStoragePathFromParameter.$this->uploadsSegment;

    }

    private function getProjectDir(): string
    {
        return $this->projectDir;
    }

    public function getUploadsSegment(): string
    {
        return $this->uploadsSegment;
    }

    /**
     * @return string
     * Provides complete directory path ( but not the file name )
     */
    protected function getBaseFilePathForFiles(): string
    {

        return $this->getProjectDir() . $this->getBaseFilePathSegment();
    }

    /**
     * @return string
     * Only provides the segment till uploads folder
     */
    public function getBaseFilePathSegment(): string
    {
        return $this->baseFilePathSegment;
    }

    protected function getEnvironment(): string
    {

        return $this->kernel->getEnvironment();
    }


    public function getPublicSegment():string
    {
        return $this->publicSegment;
    }

}