<?php

namespace App\Service\File\Base;

use App\Kernel;
use Symfony\Component\HttpKernel\KernelInterface;

define( 'DS', DIRECTORY_SEPARATOR );

class AbstractFileDirectoryPathNamer
{
    /** @var Kernel */
    private KernelInterface $kernel;
    /**
     * @var string
     */
    private string $projectDir;
    private string $publicFilePathSegment = '/public/uploads';

    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;

        $this->projectDir = $this->kernel->getProjectDir();

    }

    private function getProjectDir(): string
    {
        return $this->projectDir;
    }

    /**
     * @return string
     * Only provides the segment
     */
    public function getPublicFilePathSegment(): string
    {
        return $this->publicFilePathSegment;
    }

    /**
     * @return string
     * Provides complete directory path ( but not the file name )
     */
    protected function getBaseFilePathForFiles(): string
    {

        return $this->getProjectDir() . $this->getPublicFilePathSegment() ;
    }
}