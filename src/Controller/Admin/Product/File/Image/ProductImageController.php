<?php
// src/Controller/ProductController.php
namespace App\Controller\Admin\Product\File\Image;

// ...
use App\Form\Admin\Product\File\DTO\ProductFileDTO;
use App\Form\Admin\Product\File\DTO\ProductFileImageDTO;
use App\Form\Admin\Product\File\Form\ProductFileCreateForm;
use App\Form\Admin\Product\File\Form\ProductFileImageCreateForm;
use App\Service\Product\File\ProductFileImageService;
use App\Service\Product\File\ProductFileService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductImageController extends AbstractController
{
    #[Route('/product/{id}/file/image/create', name: 'create_product_image')]
    public function createProductImage(EntityManagerInterface  $entityManager,
                                       ProductFileImageService $productFileImageService,
                                       Request                 $request): Response
    {
        $productImageFileDTO = new ProductFileImageDTO();

        $form = $this->createForm(ProductFileImageCreateForm::class, $productImageFileDTO);
        // $productFileDTO = new ProductFileDTO();

        //   $form = $this->createForm(ProductFileCreateForm::class, $productFileDTO);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $productImageEntity = $productFileImageService->mapFormDTO($data);
            $productFileImageService->moveFile($data);

            $entityManager->persist($productImageEntity);
            $entityManager->flush();
            return $this->redirectToRoute('common/file/success_create.html.twig');


        }

            return $this->render('admin/product/file/image/create.html.twig', ['form' => $form]);
    }


}