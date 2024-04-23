<?php
// src/Controller/CategoryController.php
namespace App\Controller\Admin\Product\Category\File\Image;

// ...
use App\Controller\Admin\Product\Category\File\ListObject\CategoryImageFileObject;
use App\Entity\CategoryImageFile;
use App\Form\Admin\Product\Category\File\DTO\CategoryFileImageDTO;
use App\Form\Admin\Product\Category\File\Form\CategoryFileImageCreateForm;
use App\Repository\CategoryFileRepository;
use App\Repository\CategoryImageFileRepository;
use App\Repository\FileRepository;
use App\Service\Admin\List\ListGrid;
use App\Service\Common\List\Column\ListGridColumn;
use App\Service\Common\List\ListGridConfig;
use App\Service\Product\Category\File\Image\CategoryFileImageService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryImageController extends AbstractController
{
    #[Route('/category/{id}/file/image/create', name: 'category_file_image_create')]
    public function create(EntityManagerInterface $entityManager, CategoryFileImageService $categoryFileImageService, Request $request): Response
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
    public function list(int $id, EntityManagerInterface $entityManager, CategoryImageFileRepository $categoryImageFileRepository, CategoryFileRepository $categoryFileRepository, CategoryFileImageService $categoryFileImageService, Request $request): Response
    {


        $categoryImageFiles = $categoryImageFileRepository->findAllByCategoryId($id);

        $entities = [];
        if($categoryImageFiles != null){
            /** @var CategoryImageFile $categoryImageFile */
            foreach ($categoryImageFiles as $categoryImageFile){
                $f = new CategoryImageFileObject();
                $f->id = $categoryImageFile->getCategoryFile()->getFile()->getId();
                $f->yourFileName = $categoryImageFile->getCategoryFile()->getFile()->getYourFileName();
                $f->name = $categoryImageFile->getCategoryFile()->getFile()->getName();
                $entities[] = $f;
            }
        }

        $listGrid = ['title' => "Category Files",
            'function' => 'category_file_image',
            'columns' => [
                ['label' => 'Your fileName', 'propertyName' => 'yourFileName', 'action' => 'display'],
                ['label' => 'FileName', 'propertyName' => 'name'],
        ],
            'createButtonConfig' => [
                'function' => 'category_file_image',
                'id'=>$id,
                'anchorText' => 'Category File'
            ]
        ];

        return $this->render('admin/ui/panel/section/content/list/list.html.twig',
            ['entities' => $entities, 'listGrid' => $listGrid]);

    }

    #[\Symfony\Component\Routing\Attribute\Route('/category/{id}/file/image/fetch', name: 'category_file_image_fetch')]
    public function fetch(int $id, CategoryImageFileRepository $categoryImageFileRepository, CategoryFileImageService $categoryFileImageService, Request $request): Response
    {

        /** @var CategoryImageFile $fileEntity */
        $fileEntity = $categoryImageFileRepository->findOneBy(['id' => $id]);
        $path = $categoryFileImageService->getFullPhysicalPathForFileByName($id, $fileEntity->getCategoryFile()->getFile()->getName());

        $file = file_get_contents($path);

        $headers = array('Content-Type' => $fileEntity->getCategoryFile()->getFile()->getType()->getMimeType(), 'Content-Disposition' => 'inline; filename="' . $fileEntity->getCategoryFile()->getFile()->getName() . '"');
        return new Response($file, 200, $headers);

    }

    #[\Symfony\Component\Routing\Attribute\Route('/category/image/file/{$id}/display/', name: 'category_file_image_display')]
    public function display(CategoryImageFileRepository $categoryImageFileRepository, int $id): Response
    {
        $categoryImageFile = $categoryImageFileRepository->findByFileId($id);
        if (!$categoryImageFile) {
            throw $this->createNotFoundException('No Category ImageFile found for file id ' . $id);
        }
        $entity = [
            'id'=>$categoryImageFile->getCategoryFile()->getFile()->getId(),
            'name'=> $categoryImageFile->getCategoryFile()->getFile()->getName(),
            'yourFileName'=>$categoryImageFile->getCategoryFile()->getFile()->getYourFileName(),
            'categoryImageFileType'=>$categoryImageFile->getCategoryImageType()->getDescription()
        ];

        $displayParams = ['title' => 'CategoryImageFile',
            'editButtonLinkText' => 'Edit',
            'fields' => [
                ['label' => 'Your Name', 'propertyName' => 'yourFileName'],
                ['label' => 'Name', 'propertyName' => 'name'],
                ['label' => 'Image File Type', 'propertyName' => 'categoryImageFileType']
            ]];

        return $this->render('admin/category/file/image/category_file_image_display.html.twig',
            ['entity' => $entity, 'params' => $displayParams]);

    }

}