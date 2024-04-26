<?php
// src/Controller/ProductController.php
namespace App\Controller\Admin\Product\File\Image;

// ...
use App\Controller\Admin\Product\File\ListObject\ProductImageFileObject;
use App\Controller\Common\Identification\CommonIdentificationConstants;
use App\Controller\Common\Utility\CommonUtility;
use App\Entity\ProductImageFile;
use App\Form\Admin\Product\File\DTO\ProductFileImageDTO;
use App\Form\Admin\Product\File\Image\Form\ProductImageFileCreateForm;
use App\Form\Admin\Product\File\Image\Form\ProductImageFileEditForm;
use App\Repository\ProductImageFileRepository;
use App\Service\Product\File\Image\ProductFileImageOperation;
use App\Service\Product\File\Image\Mapper\ProductImageFileDTOMapper;
use App\Service\Product\File\Provider\ProductDirectoryImagePathProvider;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 *
 */
class ProductImageFileController extends AbstractController
{
    /**
     * @param int $id
     * @param EntityManagerInterface $entityManager
     * @param ProductImageFileDTOMapper $productImageFileMapper
     * @param ProductFileImageOperation $productFileImageOperation
     * @param CommonUtility $commonUtility
     * @param Request $request
     * @return Response
     */
    #[Route('/product/{id}/file/image/create', name: 'product_file_image_create')]
    public function create(int $id, EntityManagerInterface $entityManager, ProductImageFileDTOMapper $productImageFileMapper, ProductFileImageOperation $productFileImageOperation, CommonUtility $commonUtility, Request $request): Response
    {
        $productImageFileDTO = new ProductFileImageDTO();
        $productImageFileDTO->setProductId($id);

        $form = $this->createForm(ProductImageFileCreateForm::class, $productImageFileDTO);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $productImageEntity = $productImageFileMapper->mapDtoToEntityForCreate($data);
            $productFileImageOperation->createOrReplace($data);


            $entityManager->persist($productImageEntity);
            $entityManager->flush();

            $redirect = $request->get(CommonIdentificationConstants::REDIRECT_UPON_SUCCESS_URL);

            if ($redirect != null) return $this->redirect($commonUtility->addIdToUrl($redirect, $productImageEntity->getId())); else
                return $this->redirectToRoute('common/file/success_create.html.twig');

        }

        return $this->render('admin/product/file/image/create.html.twig', ['form' => $form]);
    }

    /**
     * @param int $id
     * @param EntityManagerInterface $entityManager
     * @param ProductImageFileRepository $productImageFileRepository
     * @param ProductImageFileDTOMapper $productImageFileDTOMapper
     * @param ProductFileImageOperation $productImageFileService
     * @param Request $request
     * @return Response
     *
     * id is ProductImageFile Id
     */
    #[\Symfony\Component\Routing\Attribute\Route('/product/file/image/{id}/edit', name: 'product_file_image_edit')]
    public function edit(int $id,
                         EntityManagerInterface $entityManager,
                         ProductImageFileRepository $productImageFileRepository,
                         ProductImageFileDTOMapper  $productImageFileDTOMapper,
                         ProductFileImageOperation  $productImageFileService,
                         Request                     $request): Response
    {
        $productImageFileEntity = $productImageFileRepository->findOneBy(['id' => $id]);

        $productImageFileFormDTO = $productImageFileDTOMapper->mapEntityToDto($productImageFileEntity);
        $form = $this->createForm(ProductImageFileEditForm::class, $productImageFileFormDTO);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $productImageFileEntity = $productImageFileDTOMapper->mapDtoToEntityForEdit($form->getData(),$productImageFileEntity);

            $productImageFileService->createOrReplace($data);

            $entityManager->persist($productImageFileEntity);
            $entityManager->flush();

            if ($request->get('_redirect_upon_success_url')) {
                $this->addFlash('success', "Updated created successfully");

                $success_url = $request->get('_redirect_upon_success_url') ;

                return $this->redirect($success_url);
            }

            return $this->render('/common/miscellaneous/success/create.html.twig', ['message' => 'ProductImageFile successfully created']);
        }

        return $this->render('admin/product/file/image/product_file_image_edit.html.twig',
            ['form' => $form, 'entity' => $productImageFileEntity]);

    }

    #[Route('/product/{id}/file/image/list', name: 'product_create_file_image_list')]
    public function list(int $id, ProductImageFileRepository $productImageFileRepository): Response
    {


        $productImageFiles = $productImageFileRepository->findAllByProductId($id);

        $entities = [];
        if ($productImageFiles != null) {
            /** @var ProductImageFile $productImageFile */
            foreach ($productImageFiles as $productImageFile) {
                $f = new ProductImageFileObject();
                $f->id = $productImageFile->getId();
                $f->yourFileName = $productImageFile->getProductFile()->getFile()->getYourFileName();
                $f->name = $productImageFile->getProductFile()->getFile()->getName();
                $entities[] = $f;
            }
        }

        $listGrid = ['title' => "Product Files", 'function' => 'product_file_image', 'columns' => [['label' => 'Your fileName', 'propertyName' => 'yourFileName', 'action' => 'display'], ['label' => 'FileName', 'propertyName' => 'name'],], 'createButtonConfig' => ['function' => 'product_file_image', 'id' => $id, 'anchorText' => 'Product File']];

        return $this->render('admin/ui/panel/section/content/list/list.html.twig', ['entities' => $entities, 'listGrid' => $listGrid]);

    }

    /**
     *
     * Fetch is to display image standalone ( call by URL at the top )
     * @param int $id
     * @param ProductImageFileRepository $productImageFileRepository
     * @param ProductDirectoryImagePathProvider $productDirectoryImagePathProvider
     * @return Response
     */
    #[\Symfony\Component\Routing\Attribute\Route('/product/file/image/{id}/fetch', name: 'product_file_image_fetch')]
    public function fetch(int $id, ProductImageFileRepository $productImageFileRepository, ProductDirectoryImagePathProvider $productDirectoryImagePathProvider): Response
    {

        /** @var ProductImageFile $productImageFile */
        $productImageFile = $productImageFileRepository->findOneBy(['id' => $id]);
        $path = $productDirectoryImagePathProvider->getFullPhysicalPathForFileByName($productImageFile->getProduct(), $productImageFile->getProductFile()->getFile()->getName());

        $file = file_get_contents($path);

        $headers = array('Content-Type' => $productImageFile->getMimeType(), 'Content-Disposition' => 'inline; filename="' . $productImageFile->getProductFile()->getFile()->getName() . '"');
        return new Response($file, 200, $headers);

    }

    /**
     * @param ProductImageFileRepository $productImageFileRepository
     * @param int $id
     * @return Response
     */
    #[\Symfony\Component\Routing\Attribute\Route('/product/image/file/{$id}/display/', name: 'product_file_image_display')]
    public function display(ProductImageFileRepository $productImageFileRepository, int $id): Response
    {
        $productImageFile = $productImageFileRepository->findOneBy(['id' => $id]);
        if (!$productImageFile) {
            throw $this->createNotFoundException('No Product ImageFile found for file id ' . $id);
        }
        $entity = ['id' => $productImageFile->getId(), 'name' => $productImageFile->getProductFile()->getFile()->getName(), 'yourFileName' => $productImageFile->getProductFile()->getFile()->getYourFileName(), 'productImageFileType' => $productImageFile->getProductImageType()->getDescription()];

        $displayParams = ['title' => 'ProductImageFile', 'editButtonLinkText' => 'Edit', 'fields' => [['label' => 'Your Name', 'propertyName' => 'yourFileName'], ['label' => 'Name', 'propertyName' => 'name'], ['label' => 'Image File Type', 'propertyName' => 'productImageFileType']]];

        return $this->render('admin/product/file/image/product_file_image_display.html.twig', ['entity' => $entity, 'params' => $displayParams]);

    }




    /**
     * @param int $id from ProductImageFile->getId()
     * @param ProductImageFileRepository $productImageFileRepository
     * @param ProductDirectoryImagePathProvider $productDirectoryImagePathProvider
     * @return Response
     *
     * To be displayed in img tag
     */
    #[\Symfony\Component\Routing\Attribute\Route('product/file/image/img-tag/{id}', name: 'product_image_file_for_img_tag')]
    public function getFileContentsById(int $id, ProductImageFileRepository $productImageFileRepository, ProductDirectoryImagePathProvider $productDirectoryImagePathProvider): Response
    {

        /** @var ProductImageFile $productImageFile */
        $productImageFile = $productImageFileRepository->findOneBy(['id' => $id]);
        $path = $productDirectoryImagePathProvider->getFullPhysicalPathForFileByName($productImageFile->getProduct(), $productImageFile->getName());

        return new BinaryFileResponse($path);

    }

}