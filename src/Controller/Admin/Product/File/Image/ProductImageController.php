<?php
// src/Controller/ProductController.php
namespace App\Controller\Admin\Product\File\Image;

// ...
use App\Entity\ProductImageFile;
use App\Form\Admin\Product\File\DTO\ProductFileImageDTO;
use App\Form\Admin\Product\File\Form\ProductFileImageCreateForm;
use App\Repository\ProductImageFileRepository;
use App\Service\Product\File\Image\ProductFileImageService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductImageController extends AbstractController
{
    #[Route('/product/{id}/file/image/create', name: 'product_create_file_image')]
    public function create(EntityManagerInterface  $entityManager,
                                       ProductFileImageService $productFileImageService,
                                       Request                 $request): Response
    {
        $productImageFileDTO = new ProductFileImageDTO();

        $form = $this->createForm(ProductFileImageCreateForm::class,
            $productImageFileDTO);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $productImageEntity = $productFileImageService->mapFormDTO($data);
            $productFileImageService->moveFile($data);

            $entityManager->persist($productImageEntity);
            $entityManager->flush();
            return $this->redirectToRoute('common/file/success_create.html.twig');


        }

        return $this->render('admin/product/file/image/create.html.twig',
            ['form' => $form]);
    }

    #[\Symfony\Component\Routing\Attribute\Route('/product/{id}/file/image/fetch', name: 'product_file_image_fetch')]
    public function fetch(int                        $id,
                          ProductImageFileRepository $productImageFileRepository,
                          ProductFileImageService    $productFileImageService,
                          Request                    $request): Response
    {

        /** @var ProductImageFile $fileEntity */
        $fileEntity = $productImageFileRepository->findOneBy(['id' => $id]);
        $path = $productFileImageService->getFullPhysicalPathForFileByName
        ($id,
            $fileEntity->getProductFile()->getFile()->getName());

        $file = file_get_contents($path);

        $headers = array('Content-Type' => $fileEntity->getProductFile()->getFile()->getType()
            ->getMimeType(),
            'Content-Disposition' => 'inline; filename="' . $fileEntity->getProductFile()->getFile()->getName() . '"');
        return new Response($file,
            200,
            $headers);

    }
}