<?php

namespace App\Tests\Service\File;

use App\Service\File\FileGeneralDirectoryPathNamer;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use function PHPUnit\Framework\assertEquals;

class FileGeneralDirectoryPathNamerTest extends KernelTestCase
{

    public function testGetFileFullPath()
    {
        self::bootKernel();
        $namer = new FileGeneralDirectoryPathNamer(static::$kernel);

        $expected = static::$kernel->getProjectDir().'/public/uploads/general';
        assertEquals($namer->getFullPathForImages([]),$expected);
    }
}
