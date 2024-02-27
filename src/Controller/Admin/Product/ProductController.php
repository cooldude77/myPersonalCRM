<?php
// src/Controller/ProductController.php
namespace App\Controller\Admin\Product;

// ...
use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/product/create', name: 'create_product')]
    public function createProduct(EntityManagerInterface $entityManager): Response
    {
        $product = new Product();

        return new Response('Saved new product with id '.$product->getId());
    }

    #[Route('/product/{id}', name: 'product_show')]
    public function show(ProductRepository $productRepository, int $id): Response
     {
        $product = $productRepository->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        return new Response('Check out this great product: '.$product->getProductDescription());

        // or render a template
        // in the template, print things with {{ product.name }}
        // return $this->render('product/show.html.twig', ['product' => $product]);
    } 
    
    #[Route('/product/edit/{id}', name: 'product_update')]
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

        return new Response('Check out this updated product: '.$product->getProductDescription());

        // or render a template
        // in the template, print things with {{ product.name }}
        // return $this->render('product/show.html.twig', ['product' => $product]);
    }
}