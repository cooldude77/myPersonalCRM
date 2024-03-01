<?php
// src/Controller/ProductController.php
namespace App\Controller\Admin\Product\Type\Attribute;

// ...
use App\Entity\ProductType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductTypeAttributeController extends AbstractController
{
    #[Route('/product/type/{$type}/attribute/create', name: 'product_type_attribute_create')]
    public function createProductTypeAttribute($type, EntityManagerInterface $entityManager): Response
    {
        $product = new ProductType();

        return new Response('Saved new product with id ' . $product->getId());
    }


}