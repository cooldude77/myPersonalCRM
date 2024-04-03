<?php

namespace App\Tests\Service\Product\Category\File;

use App\Service\File\FileGeneralDirectoryPathNamer;
use App\Service\Product\Category\File\CategoryFileDirectoryPathNamer;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use function PHPUnit\Framework\assertEquals;

class CategoryFileDirectoryPathNamerTest  extends KernelTestCase
{

    public function testGetFileFullPath()
    {
        self::bootKernel();
        $namer = new CategoryFileDirectoryPathNamer(static::$kernel);

        $expected =static::$kernel->getProjectDir().'/public/uploads/categories/1/images';
        assertEquals($namer->getFileFullPathImage(['id'=>1]),$expected);
    }
}
