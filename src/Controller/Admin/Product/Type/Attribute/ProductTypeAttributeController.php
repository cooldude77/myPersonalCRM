<?php
// src/Controller/ProductController.php
namespace App\Controller\Admin\Product\Type\Attribute;

// ...
use App\Entity\ProductTypeAttribute;
use App\Form\Admin\Customer\Type\ProductTypeCreateForm;
use App\Repository\ProductTypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductTypeAttributeController extends AbstractController
{
    #[Route('/product/type/{$type}/attribute/create', name: 'product_type_attribute_create')]
    public function createProductTypeAttribute($type, EntityManagerInterface $entityManager, Request $request): Response
    {
        $productTypeAttribute = new ProductTypeAttribute();

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


    #[Route('/product/{type}/attribute/list', name: 'product_type_attribute_list')]
    public function listProductTypeAttribute(ProductTypeRepository $productTypeRepository): Response
    {

        $list = $productTypeRepository->findAll();

        return $this->render('admin/product/type/attribute/list.html.twig', ['list' => $list]);

    }


}