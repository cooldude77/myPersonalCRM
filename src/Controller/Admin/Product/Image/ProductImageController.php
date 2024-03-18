<?php
// src/Controller/ProductController.php
namespace App\Controller\Admin\Product\Image;

// ...
use App\Entity\Product;
use App\Form\Admin\Product\Image\DTO\ProductFileDTO;
use App\Form\Admin\Product\Image\ProductFileCreateForm;
use App\Form\Admin\Product\ProductCreateForm;
use App\Form\Common\File\FileCreateForm;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductImageController extends AbstractController
{
    #[Route('/product/{id}/image/create', name: 'create_product_image')]
    public function createProductImage(EntityManagerInterface $entityManager, Request $request): Response
    {
        $productFileDTO = new ProductFileDTO();

        $form = $this->createForm(ProductFileCreateForm::class, $productFileDTO);

        $form->handleRequest($request);

        $data = $form->getData();

        return $this->render('admin/product/create.html.twig', ['form' => $form]);
    }


}