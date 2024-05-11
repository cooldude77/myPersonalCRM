<?php

namespace App\Tests\Controller\MasterData\Category\Image;

use App\Entity\File;
use App\Factory\CategoryFactory;
use App\Service\MasterData\Category\File\Provider\CategoryDirectoryImagePathProvider;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Zenstruck\Browser\Test\HasBrowser;

class CategoryImageControllerTest extends WebTestCase
{
    use HasBrowser;

    public function testCreate()
    {

        self::bootKernel();
        $provider = self::getContainer()->get(CategoryDirectoryImagePathProvider::class);

        $category = CategoryFactory::createOne();


        $id = $category->getId();

        $createUrl = "/category/$id/image/create";

        $fileName = 'grocery_1920.jpg';
        $uploadedFile = new UploadedFile(
            __DIR__ . '/' . $fileName, $fileName
        );
        $visit = $this->browser()
            ->visit($createUrl);

        $a = $visit->crawler()->filter('category_image_create_form[fileDTO][name]');

        $form = $visit->crawler()->selectButton('Save')->form();

        $name = $form->get('category_image_create_form[fileDTO][name]')->getValue();


        $visit->fillField('category_image_create_form[fileDTO][yourFileName]', 'MyFile.jpg')
            ->fillField(
                'category_image_create_form[fileDTO][uploadedFile]', $uploadedFile
            )->click('Save')->assertSuccessful();

        self::assertFileExists(
            $provider->getFullPhysicalPathForFileByName
            (
                $category->object(), $name.'.jpg'
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
