<?php
// src/Controller/ProductController.php
namespace App\Controller\Admin\Product\Type;

// ...
use App\Entity\ProductType;
use App\Form\Admin\Product\Type\ProductTypeCreateForm;
use App\Form\Admin\Product\Type\ProductTypeUpdateForm;
use App\Repository\ProductTypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductTypeController extends AbstractController
{
    #[Route('/product/type/create', name: 'product_type_create')]
    public function createProductType(EntityManagerInterface $entityManager, Request $request): Response
    {
        $type = new ProductType();

        $form = $this->createForm(ProductTypeCreateForm::class, $type);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // perform some action...
            $entityManager->persist($form->getData());
            $entityManager->flush();

            return $this->redirectToRoute('admin/product/type/success_create.html.twig');
        }
        return $this->render('admin/product/type/create.html.twig', ['form' => $form]);

    }

    #[Route('/product/type/update/{type}', name: 'product_type_update')]
    public function updateProductType($type, EntityManagerInterface $entityManager, Request $request, ProductTypeRepository $productTypeRepository): Response
    {
        $type = $productTypeRepository->findOneBy(['type' => $type]);

        $form = $this->createForm(ProductTypeUpdateForm::class, $type);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // perform some action...
            $entityManager->persist($form->getData());
            $entityManager->flush();

            return $this->redirectToRoute('admin/product/type/success_update.html.twig');
        }
        return $this->render('admin/product/type/update.html.twig', ['form' => $form]);

    }

    #[Route('/product/type/list', name: 'product_type_list')]
    public function listProductType(ProductTypeRepository $productTypeRepository): Response
    {

        $list = $productTypeRepository->findAll();

        return $this->render('admin/product/type/list.html.twig', ['list' => $list]);

    }

    #[Route('/product/type/delete/{type}', name: 'product_type_delete')]
    public function deleteProductType($type, ProductTypeRepository $productTypeRepository, EntityManagerInterface $entityManager): Response
    {

        $productType = $productTypeRepository->findOneBy(['type' => $type]);

        $entityManager->remove($productType);

        $entityManager->flush();
        return new Response("Success");

    }

}