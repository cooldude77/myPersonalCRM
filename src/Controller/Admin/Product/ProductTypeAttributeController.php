<?php
// src/Controller/ProductController.php
namespace App\Controller\Admin\Product;

// ...
use App\Entity\ProductType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductTypeAttributeController extends AbstractController
{
    #[Route('/product/type/attribute/create', name: 'create_product_type_attribute')]
    public function createProduct(EntityManagerInterface $entityManager): Response
    {
        $product = new ProductType();

        return new Response('Saved new product with id ' . $product->getId());
    }


}