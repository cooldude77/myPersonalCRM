<?php
// src/Controller/CategoryController.php
namespace App\Controller\Admin\Product\Category\File\Image;

// ...
use App\Controller\Admin\Product\Category\File\ListObject\CategoryImageFileObject;
use App\Controller\Common\Identification\CommonIdentificationConstants;
use App\Controller\Common\Utility\CommonUtility;
use App\Entity\CategoryImageFile;
use App\Form\Admin\Product\Category\File\DTO\CategoryFileImageDTO;
use App\Form\Admin\Product\Category\File\Image\Form\CategoryImageFileCreateForm;
use App\Form\Admin\Product\Category\File\Image\Form\CategoryImageFileEditForm;
use App\Repository\CategoryImageFileRepository;
use App\Service\Product\Category\File\Image\CategoryFileImageOperation;
use App\Service\Product\Category\File\Image\Mapper\CategoryImageFileDTOMapper;
use App\Service\Product\Category\File\Provider\CategoryDirectoryImagePathProvider;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 *
 */
class CategoryImageFileController extends AbstractController
{
    /**
     * @param int $id
     * @param EntityManagerInterface $entityManager
     * @param CategoryImageFileDTOMapper $categoryImageFileMapper
     * @param CategoryFileImageOperation $categoryFileImageOperation
     * @param CommonUtility $commonUtility
     * @param Request $request
     * @return Response
     */
    #[Route('/category/{id}/file/image/create', name: 'category_file_image_create')]
    public function create(int $id, EntityManagerInterface $entityManager, CategoryImageFileDTOMapper $categoryImageFileMapper, CategoryFileImageOperation $categoryFileImageOperation, CommonUtility $commonUtility, Request $request): Response
    {
        $categoryImageFileDTO = new CategoryFileImageDTO();
        $categoryImageFileDTO->setCategoryId($id);

        $form = $this->createForm(CategoryImageFileCreateForm::class, $categoryImageFileDTO);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $categoryImageEntity = $categoryImageFileMapper->mapDtoToEntityForCreate($data);
            $categoryFileImageOperation->createOrReplace($data);


            $entityManager->persist($categoryImageEntity);
            $entityManager->flush();

            $redirect = $request->get(CommonIdentificationConstants::REDIRECT_UPON_SUCCESS_URL);

            if ($redirect != null) return $this->redirect($commonUtility->addIdToUrl($redirect, $categoryImageEntity->getId())); else
                return $this->redirectToRoute('common/file/success_create.html.twig');

        }

        return $this->render('admin/category/file/image/create.html.twig', ['form' => $form]);
    }

    /**
     * @param int $id
     * @param EntityManagerInterface $entityManager
     * @param CategoryImageFileRepository $categoryImageFileRepository
     * @param CategoryImageFileDTOMapper $categoryImageFileDTOMapper
     * @param CategoryFileImageOperation $categoryImageFileService
     * @param Request $request
     * @return Response
     *
     * id is CategoryImageFile Id
     */
    #[\Symfony\Component\Routing\Attribute\Route('/category/file/image/{id}/edit', name: 'category_file_image_edit')]
    public function edit(int $id,
                         EntityManagerInterface $entityManager,
                         CategoryImageFileRepository $categoryImageFileRepository,
                         CategoryImageFileDTOMapper  $categoryImageFileDTOMapper,
                         CategoryFileImageOperation  $categoryImageFileService,
                         Request                     $request): Response
    {
        $categoryImageFileEntity = $categoryImageFileRepository->findOneBy(['id' => $id]);

        $categoryImageFileFormDTO = $categoryImageFileDTOMapper->mapEntityToDto($categoryImageFileEntity);
        $form = $this->createForm(CategoryImageFileEditForm::class, $categoryImageFileFormDTO);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $categoryImageFileEntity = $categoryImageFileDTOMapper->mapDtoToEntityForEdit($form->getData(),$categoryImageFileEntity);

            $categoryImageFileService->createOrReplace($data);

            $entityManager->persist($categoryImageFileEntity);
            $entityManager->flush();

            if ($request->get('_redirect_upon_success_url')) {
                $this->addFlash('success', "Updated created successfully");

                $success_url = $request->get('_redirect_upon_success_url') ;

                return $this->redirect($success_url);
            }

            return $this->render('/common/miscellaneous/success/create.html.twig', ['message' => 'CategoryImageFile successfully created']);
        }

        return $this->render('admin/category/file/image/category_file_image_edit.html.twig',
            ['form' => $form, 'entity' => $categoryImageFileEntity]);

    }

    #[Route('/category/{id}/file/image/list', name: 'category_create_file_image_list')]
    public function list(int $id, CategoryImageFileRepository $categoryImageFileRepository): Response
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
     * @param CategoryDirectoryImagePathProvider $categoryDirectoryImagePathProvider
     * @return Response
     */
    #[\Symfony\Component\Routing\Attribute\Route('/category/file/image/{id}/fetch', name: 'category_file_image_fetch')]
    public function fetch(int $id, CategoryImageFileRepository $categoryImageFileRepository, CategoryDirectoryImagePathProvider $categoryDirectoryImagePathProvider): Response
    {

        /** @var CategoryImageFile $categoryImageFile */
        $categoryImageFile = $categoryImageFileRepository->findOneBy(['id' => $id]);
        $path = $categoryDirectoryImagePathProvider->getFullPhysicalPathForFileByName($categoryImageFile->getCategory(), $categoryImageFile->getCategoryFile()->getFile()->getName());

        $file = file_get_contents($path);

        $headers = array('Content-Type' => $categoryImageFile->getMimeType(), 'Content-Disposition' => 'inline; filename="' . $categoryImageFile->getCategoryFile()->getFile()->getName() . '"');
        return new Response($file, 200, $headers);

    }

    /**
     * @param CategoryImageFileRepository $categoryImageFileRepository
     * @param int $id
     * @return Response
     */
    #[\Symfony\Component\Routing\Attribute\Route('/category/image/file/{$id}/display/', name: 'category_file_image_display')]
    public function display(CategoryImageFileRepository $categoryImageFileRepository, int $id): Response
    {
        $categoryImageFile = $categoryImageFileRepository->findOneBy(['id' => $id]);
        if (!$categoryImageFile) {
            throw $this->createNotFoundException('No Category ImageFile found for file id ' . $id);
        }
        $entity = ['id' => $categoryImageFile->getId(), 'name' => $categoryImageFile->getCategoryFile()->getFile()->getName(), 'yourFileName' => $categoryImageFile->getCategoryFile()->getFile()->getYourFileName(), 'categoryImageFileType' => $categoryImageFile->getCategoryImageType()->getDescription()];

        $displayParams = ['title' => 'CategoryImageFile', 'editButtonLinkText' => 'Edit', 'fields' => [['label' => 'Your Name', 'propertyName' => 'yourFileName'], ['label' => 'Name', 'propertyName' => 'name'], ['label' => 'Image File Type', 'propertyName' => 'categoryImageFileType']]];

        return $this->render('admin/category/file/image/category_file_image_display.html.twig', ['entity' => $entity, 'params' => $displayParams]);

    }




    /**
     * @param int $id from CategoryImageFile->getId()
     * @param CategoryImageFileRepository $categoryImageFileRepository
     * @param CategoryDirectoryImagePathProvider $categoryDirectoryImagePathProvider
     * @return Response
     *
     * To be displayed in img tag
     */
    #[\Symfony\Component\Routing\Attribute\Route('category/file/image/img-tag/{id}', name: 'category_image_file_for_img_tag')]
    public function getFileContentsById(int $id, CategoryImageFileRepository $categoryImageFileRepository, CategoryDirectoryImagePathProvider $categoryDirectoryImagePathProvider): Response
    {

        /** @var CategoryImageFile $categoryImageFile */
        $categoryImageFile = $categoryImageFileRepository->findOneBy(['id' => $id]);
        $path = $categoryDirectoryImagePathProvider->getFullPhysicalPathForFileByName($categoryImageFile->getCategory(), $categoryImageFile->getName());

        return new BinaryFileResponse($path);

    }

}