<?php

namespace App\Service\File\Base;

use App\Kernel;
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
    private string $publicFilePathSegment = '/public/uploads';

    private string $publicSegment = '/public';

    private string $uploadsSegment ='/uploads';

    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;

        $this->projectDir = $this->kernel->getProjectDir();

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

        return $this->getProjectDir() . $this->getPublicFilePathSegment();
    }

    /**
     * @return string
     * Only provides the segment till uploads folder
     */
    public function getPublicFilePathSegment(): string
    {
        return $this->publicFilePathSegment;
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