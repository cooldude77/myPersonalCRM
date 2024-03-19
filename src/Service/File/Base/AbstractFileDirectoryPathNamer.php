<?php

namespace App\Service\File\Base;

use App\Kernel;
use Symfony\Component\HttpKernel\KernelInterface;

class AbstractFileDirectoryPathNamer
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

    public function getProjectDir(): string
    {
        return $this->projectDir;
    }

    public function getFileBaseDirPathSegment(): string
    {
        return $this->fileBaseDirPathSegment;
    }


}