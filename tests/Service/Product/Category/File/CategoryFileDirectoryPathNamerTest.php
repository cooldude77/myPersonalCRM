<?php

namespace App\Tests\Service\Product\Category\File;

use App\Service\MasterData\Category\File\Provider\CategoryDirectoryPathProvider;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use function PHPUnit\Framework\assertEquals;

class CategoryFileDirectoryPathNamerTest  extends KernelTestCase
{

    public function testGetFileFullPath()
    {
        self::bootKernel();
        $namer = new CategoryDirectoryPathProvider(static::$kernel);

        $expected =static::$kernel->getProjectDir().'/public/uploads/categories/1/images';
        assertEquals($namer->getFullPathForImageFiles(['id'=>1]),$expected);
    }
}
