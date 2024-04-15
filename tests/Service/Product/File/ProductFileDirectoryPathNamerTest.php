<?php

namespace App\Tests\Service\Product\File;

use App\Service\Product\File\Provider\ProductDirectoryPathProvider;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use function PHPUnit\Framework\assertEquals;

class ProductFileDirectoryPathNamerTest  extends KernelTestCase
{

    public function testGetFileFullPath()
    {
        self::bootKernel();
        $namer = new ProductDirectoryPathProvider(static::$kernel);

        $expected =static::$kernel->getProjectDir().'/public/uploads/products/1/images';
        assertEquals($namer->getFullPathForImageFiles(['id'=>1]),$expected);
    }
}