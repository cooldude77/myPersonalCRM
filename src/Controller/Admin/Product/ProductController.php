<?php
// src/Controller/ProductController.php
namespace App\Controller\Admin\Product;

// ...
use App\Entity\Product;
use App\Form\Admin\Product\ProductCreateForm;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/product/create', name: 'create_product')]
    public function createProduct(EntityManagerInterface $entityManager, Request $request): Response
    {
        $type = new Product();

        $form = $this->createForm(ProductCreateForm::class, $type);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // perform some action...
            $entityManager->persist($form->getData());
            $entityManager->flush();

            return $this->redirectToRoute('admin/product/success_create.html.twig');
        }
        return $this->render('admin/product/create.html.twig', ['form' => $form]);
    }


    #[Route('/product/edit/{id}', name: 'product_edit')]
    public function update(ProductRepository $productRepository, int $id): Response
     {
        $product = $productRepository->find($id);

        
        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

         $product->setProductDescription('New .... ');
         $productRepository->getEntityManager()->flush($product);

         return new Response('Check out this updated product: ' . $product->getProductDescription());

         // or render a template
         // in the template, print things with {{ product.name }}
         // return $this->render('product/show.html.twig', ['product' => $product]);
     }

    #[Route('/product/list', name: 'product_list')]
    public function list(ProductRepository $productRepository): Response
    {
        $product = $productRepository->findAll();

        return new Response('Check out this updated product:');

        // or render a template
        // in the template, print things with {{ product.name }}
        // return $this->render('product/show.html.twig', ['product' => $product]);
    }
}