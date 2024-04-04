<?php

namespace App\Tests\Service\File;

use App\Service\File\Provider\GeneralDirectoryPathProvider;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use function PHPUnit\Framework\assertEquals;

class FileGeneralDirectoryPathNamerTest extends KernelTestCase
{

    public function testGetFileFullPath()
    {
        self::bootKernel();
        $namer = new GeneralDirectoryPathProvider(static::$kernel);

        $expected = static::$kernel->getProjectDir().'/public/uploads/general';
        assertEquals($namer->getFullPathForImages([]),$expected);
    }
}
