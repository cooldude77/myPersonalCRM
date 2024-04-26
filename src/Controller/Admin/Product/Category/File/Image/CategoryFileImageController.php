<?php
// src/Controller/CategoryController.php
namespace App\Controller\Admin\Product\Category\File\Image;

// ...
use App\Controller\Admin\Product\Category\File\ListObject\CategoryImageFileObject;
use App\Controller\Common\Identification\CommonIdentificationConstants;
use App\Controller\Common\Utility\CommonUtility;
use App\Entity\CategoryImageFile;
use App\Entity\File;
use App\Form\Admin\Product\Category\File\DTO\CategoryFileImageDTO;
use App\Form\Admin\Product\Category\File\Form\CategoryFileImageCreateForm;
use App\Repository\CategoryFileRepository;
use App\Repository\CategoryImageFileRepository;
use App\Repository\FileRepository;
use App\Service\File\Provider\FileDirectoryPathProvider;
use App\Service\Product\Category\File\Image\CategoryFileImageOperation;
use App\Service\Product\Category\File\Image\Mapper\CategoryImageFileDTOMapper;
use App\Service\Product\Category\File\Provider\CategoryDirectoryImagePathProvider;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryFileImageController extends AbstractController
{
    #[Route('/category/{id}/file/image/create', name: 'category_file_image_create')]
    public function create(int                        $id, EntityManagerInterface $entityManager,
                           CategoryImageFileDTOMapper $categoryImageFileMapper,
                           CategoryFileImageOperation $categoryFileImageOperation,
                           CommonUtility              $commonUtility, Request $request): Response
    {
        $categoryImageFileDTO = new CategoryFileImageDTO();
        $categoryImageFileDTO->setCategoryId($id);

        $form = $this->createForm(CategoryFileImageCreateForm::class, $categoryImageFileDTO);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $categoryImageEntity = $categoryImageFileMapper->mapFormDTO($data);
            $categoryFileImageOperation->createOrReplace($data);


            $entityManager->persist($categoryImageEntity);
            $entityManager->flush();

            $redirect = $request->get(CommonIdentificationConstants::REDIRECT_UPON_SUCCESS_URL);

            if ($redirect != null) return $this->redirect($commonUtility->addIdToUrl($redirect, $categoryImageEntity->getId())); else
                return $this->redirectToRoute('common/file/success_create.html.twig');

        }

        return $this->render('admin/category/file/image/create.html.twig', ['form' => $form]);
    }

    #[Route('/category/{id}/file/image/list', name: 'category_create_file_image_list')]
    public function list(int $id, EntityManagerInterface $entityManager, CategoryImageFileRepository $categoryImageFileRepository, CategoryFileRepository $categoryFileRepository, CategoryFileImageOperation $categoryFileImageService, Request $request): Response
    {


        $categoryImageFiles = $categoryImageFileRepository->findAllByCategoryId($id);

        $entities = [];
        if ($categoryImageFiles != null) {
            /** @var CategoryImageFile $categoryImageFile */
            foreach ($categoryImageFiles as $categoryImageFile) {
                $f = new CategoryImageFileObject();
                $f->id = $categoryImageFile->getId();
                $f->yourFileName = $categoryImageFile->getCategoryFile()->getFile()->getYourFileName();
                $f->name = $categoryImageFile->getCategoryFile()->getFile()->getName();
                $entities[] = $f;
            }
        }

        $listGrid = ['title' => "Category Files", 'function' => 'category_file_image', 'columns' => [['label' => 'Your fileName', 'propertyName' => 'yourFileName', 'action' => 'display'], ['label' => 'FileName', 'propertyName' => 'name'],], 'createButtonConfig' => ['function' => 'category_file_image', 'id' => $id, 'anchorText' => 'Category File']];

        return $this->render('admin/ui/panel/section/content/list/list.html.twig', ['entities' => $entities, 'listGrid' => $listGrid]);

    }

    /**
     *
     * Fetch is to display image standalone ( call by URL at the top )
     * @param int $id
     * @param CategoryImageFileRepository $categoryImageFileRepository
     * @param CategoryFileImageOperation $categoryDirectoryImagePathProvider
     * @param Request $request
     * @return Response
     */
    #[\Symfony\Component\Routing\Attribute\Route('/category/file/image/{id}/fetch', name: 'category_file_image_fetch')]
    public function fetch(int                                $id, CategoryImageFileRepository $categoryImageFileRepository,
                          CategoryDirectoryImagePathProvider $categoryDirectoryImagePathProvider, Request $request): Response
    {

        /** @var CategoryImageFile $categoryImageFile */
        $categoryImageFile = $categoryImageFileRepository->findOneBy(['id' => $id]);
        $path = $categoryDirectoryImagePathProvider->getFullPhysicalPathForFileByName($id, $categoryImageFile->getCategoryFile()->getFile()->getName());

        $file = file_get_contents($path);

        $headers = array('Content-Type' => $categoryImageFile->getMimeType(), 'Content-Disposition' => 'inline; filename="' . $categoryImageFile->getCategoryFile()->getFile()->getName() . '"');
        return new Response($file, 200, $headers);

    }

    #[\Symfony\Component\Routing\Attribute\Route('/category/image/file/{$id}/display/', name: 'category_file_image_display')]
    public function display(CategoryImageFileRepository $categoryImageFileRepository, int $id): Response
    {
        $categoryImageFile = $categoryImageFileRepository->findOneBy(['id'=>$id]);
        if (!$categoryImageFile) {
            throw $this->createNotFoundException('No Category ImageFile found for file id ' . $id);
        }
        $entity = ['id' => $categoryImageFile->getId(), 'name' => $categoryImageFile->getCategoryFile()->getFile()->getName(), 'yourFileName' => $categoryImageFile->getCategoryFile()->getFile()->getYourFileName(), 'categoryImageFileType' => $categoryImageFile->getCategoryImageType()->getDescription()];

        $displayParams = ['title' => 'CategoryImageFile', 'editButtonLinkText' => 'Edit', 'fields' => [['label' => 'Your Name', 'propertyName' => 'yourFileName'], ['label' => 'Name', 'propertyName' => 'name'], ['label' => 'Image File Type', 'propertyName' => 'categoryImageFileType']]];

        return $this->render('admin/category/file/image/category_file_image_display.html.twig', [
            'entity' => $entity,
            'params' => $displayParams]);

    }


    #[\Symfony\Component\Routing\Attribute\Route('/category/file/image/{id}/edit', name: 'category_file_image_edit')]
    public function edit(int $id, EntityManagerInterface $entityManager, CategoryImageFileRepository $categoryImageFileRepository, CategoryImageFileDTOMapper $categoryImageFileDTOMapper, CategoryFileImageOperation $categoryImageFileService, CategoryDirectoryImagePathProvider $categoryDirectoryImagePathProvider, Request $request): Response
    {
        $categoryImageFileEntity = $categoryImageFileRepository->findOneBy(['id' => $id]);

        $categoryImageFileFormDTO = $categoryImageFileDTOMapper->mapFormDTO($categoryImageFileEntity);
        $form = $this->createForm(CategoryImageFileUpdateForm::class, $categoryImageFileFormDTO);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $categoryImageFileEntity = $categoryImageFileDTOMapper->mapFormDTO($form->getData(), $categoryImageFileEntity);
            $categoryImageFileService->createOrReplace($categoryImageFileFormDTO->uploadedCategoryImageFile);

            $entityManager->persist($categoryImageFileEntity);
            $entityManager->flush();

            if ($request->get('_redirect_upon_success_url')) {
                $this->addFlash('success', "Updated created successfully");

                $id = $categoryImageFileEntity->getId();
                $success_url = $request->get('_redirect_upon_success_url') . "&id={$id}";

                return $this->redirect($success_url);
            }

            return $this->render('/common/miscellaneous/success/create.html.twig', ['message' => 'CategoryImageFile successfully created']);
        }

        return $this->render('common/categoryImageFile/edit.html.twig', ['form' => $form, 'entity' => $categoryImageFileEntity]);
    }


    /**
     * @param int $id from CategoryImageFile->getId()
     * @param FileRepository $categoryFileRepository
     * @param FileDirectoryPathProvider $directoryPathProvider
     * @return Response
     *
     * To be displayed in img tag
     */
    #[\Symfony\Component\Routing\Attribute\Route('category/file/image/img-tag/{id}', name: 'category_image_file_for_img_tag')]
    public function getFileContentsById(int                       $id,
                                        CategoryImageFileRepository $categoryImageFileRepository,
                                        CategoryDirectoryImagePathProvider $categoryDirectoryImagePathProvider): Response
    {

        /** @var CategoryImageFile $categoryImageFile */
        $categoryImageFile = $categoryImageFileRepository->findOneBy(['id' => $id]);
        $path = $categoryDirectoryImagePathProvider->getFullPhysicalPathForFileByName($categoryImageFile->getCategory(),$categoryImageFile->getName());

        return new BinaryFileResponse($path);

    }

}