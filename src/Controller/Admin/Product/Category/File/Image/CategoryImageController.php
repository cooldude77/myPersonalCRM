<?php
// src/Controller/CategoryController.php
namespace App\Controller\Admin\Product\Category\File\Image;

// ...
use App\Entity\CategoryImageFile;
use App\Form\Admin\Product\Category\File\DTO\CategoryFileImageDTO;
use App\Form\Admin\Product\Category\File\Form\CategoryFileImageCreateForm;
use App\Repository\CategoryFileRepository;
use App\Repository\CategoryImageFileRepository;
use App\Repository\FileRepository;
use App\Service\File\FileService;
use App\Service\File\Provider\FileDirectoryPathProvider;
use App\Service\Product\Category\File\Image\CategoryFileImageService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryImageController extends AbstractController
{
    #[Route('/category/{id}/file/image/create', name: 'category_create_file_image')]
    public function createCategoryImage(EntityManagerInterface  $entityManager,
                                       CategoryFileImageService $categoryFileImageService,
                                       Request                 $request): Response
    {
        $categoryImageFileDTO = new CategoryFileImageDTO();

        $form = $this->createForm(CategoryFileImageCreateForm::class, $categoryImageFileDTO);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $categoryImageEntity = $categoryFileImageService->mapFormDTO($data);
            $categoryFileImageService->moveFile($data);

            $entityManager->persist($categoryImageEntity);
            $entityManager->flush();
            return $this->redirectToRoute('common/file/success_create.html.twig');


        }

            return $this->render('admin/category/file/image/create.html.twig', ['form' => $form]);
    }
    #[Route('/category/{id}/file/image/list', name: 'category_create_file_image_list')]
    public function list( int $id,
        EntityManagerInterface  $entityManager,
                                       CategoryFileImageService $categoryFileImageService,
                                       Request                 $request): Response
    {
        $categoryImageFileDTO = new CategoryFileImageDTO();

        $form = $this->createForm(CategoryFileImageCreateForm::class, $categoryImageFileDTO);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $categoryImageEntity = $categoryFileImageService->mapFormDTO($data);
            $categoryFileImageService->moveFile($data);

            $entityManager->persist($categoryImageEntity);
            $entityManager->flush();
            return $this->redirectToRoute('common/file/success_create.html.twig');


        }

            return $this->render('admin/category/file/image/create.html.twig', ['form' => $form]);
    }

    #[\Symfony\Component\Routing\Attribute\Route('/category/{id}/file/image/fetch', name: 'category_file_image_fetch')]
    public function fetch(int                         $id,
                          CategoryImageFileRepository $categoryImageFileRepository,
                          CategoryFileImageService    $categoryFileImageService,
                          Request                     $request): Response
    {

        /** @var CategoryImageFile $fileEntity */
        $fileEntity = $categoryImageFileRepository->findOneBy(['id' => $id]);
        $path = $categoryFileImageService->getFullPhysicalPathForFileByName
        ($id,$fileEntity->getCategoryFile()->getFile()->getName());

        $file = file_get_contents($path);

        $headers = array('Content-Type' => $fileEntity->getCategoryFile()->getFile()->getType()
            ->getMimeType(),
            'Content-Disposition' => 'inline; filename="' . $fileEntity->getCategoryFile()->getFile()->getName() . '"');
        return new Response($file,
            200,
            $headers);

    }
}