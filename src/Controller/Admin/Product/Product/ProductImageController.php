<?php
// src/Controller/ProductController.php
namespace App\Controller\Admin\Product\Product;

// ...
use App\Config\Admin\ProductFieldList;
use App\Entity\Product;
use App\Form\Admin\Product\ProductCreateForm;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductImageController extends AbstractController
{
    #[Route('/product/{id}image/create', name: 'product_create')]
    public function createProductImage(EntityManagerInterface $entityManager, Request $request): Response
    {
        $type = new Product();

        $form = $this->createForm(ProductCreateForm::class, $type);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // perform some action...
            $entityManager->persist($form->getData());
            $entityManager->flush();

            $response = $this->render('admin/product/success.html.twig');
            $response->setStatusCode(401);

            return $response;
        }
        return $this->render('admin/product/create.html.twig', ['form' => $form]);
    }



}