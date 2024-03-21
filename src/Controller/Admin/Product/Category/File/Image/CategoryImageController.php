<?php
// src/Controller/CategoryController.php
namespace App\Controller\Admin\Product\Category\File\Image;

// ...
use App\Form\Admin\Product\Category\File\DTO\CategoryFileImageDTO;
use App\Form\Admin\Product\Category\File\Form\CategoryFileImageCreateForm;
use App\Service\Product\Category\File\CategoryFileImageService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryImageController extends AbstractController
{
    #[Route('/category/{id}/file/image/create', name: 'create_Category_image')]
    public function createCategoryImage(EntityManagerInterface  $entityManager,
                                       CategoryFileImageService $categoryFileImageService,
                                       Request                 $request): Response
    {
        $categoryImageFileDTO = new CategoryFileImageDTO();

        $form = $this->createForm(CategoryFileImageCreateForm::class, $categoryImageFileDTO);
        // $categoryFileDTO = new CategoryFileDTO();

        //   $form = $this->createForm(CategoryFileCreateForm::class, $categoryFileDTO);

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


}