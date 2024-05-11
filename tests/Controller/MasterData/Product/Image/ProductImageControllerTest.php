<?php

namespace App\Tests\Controller\MasterData\Product\Image;

use App\Factory\ProductFactory;
use App\Service\MasterData\Product\Image\Provider\ProductDirectoryImagePathProvider;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Zenstruck\Browser\Test\HasBrowser;

class ProductImageControllerTest extends WebTestCase
{
    use HasBrowser;

    public function testCreate()
    {

        self::bootKernel();
        $provider = self::getContainer()->get(ProductDirectoryImagePathProvider::class);

        $product = ProductFactory::createOne();


        $id = $product->getId();

        $createUrl = "/product/$id/image/create";

        $fileName = 'grocery_1920.jpg';
        $uploadedFile = new UploadedFile(
            __DIR__ . '/' . $fileName, $fileName
        );
        $visit = $this->browser()
            ->visit($createUrl);

        $form = $visit->crawler()->selectButton('Save')->form();

        $name = $form->get('product_image_create_form[fileDTO][name]')->getValue();


        $visit->fillField('product_image_create_form[fileDTO][yourFileName]', 'MyFile.jpg')
            ->fillField(
                'product_image_create_form[fileDTO][uploadedFile]', $uploadedFile
            )->click('Save')->assertSuccessful();

        self::assertFileExists(
            $provider->getFullPhysicalPathForFileByName
            (
                $product->object(), $name.'.jpg'
            )
        );


    }

    // Todo: Create List test case
    // todo: create edit test case
    protected function tearDown(): void
    {
        $root = self::getContainer()->getParameter('kernel.project_dir');
        $path =  $root.self::getContainer()->getParameter('file_storage_path');

        shell_exec("rm -rf ".$path);
    }
}
