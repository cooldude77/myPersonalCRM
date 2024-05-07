<?php
// src/Controller/ProductController.php
namespace App\Controller\MasterData\Product\Product;

// ...
use App\Form\MasterData\Product\DTO\ProductDTO;
use App\Form\MasterData\Product\ProductCreateForm;
use App\Form\MasterData\Product\ProductEditForm;
use App\Repository\ProductRepository;
use App\Service\MasterData\Product\Mapper\ProductDTOMapper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{

    #[\Symfony\Component\Routing\Attribute\Route('/product/create', 'product_create')]
    public function create(ProductDTOMapper $productDTOMapper,
        EntityManagerInterface $entityManager, Request $request
    ): Response {
        $productDTO = new ProductDTO();
        $form = $this->createForm(
            ProductCreateForm::class, $productDTO
        );

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $productEntity = $productDTOMapper->mapToEntityForCreate($form);


            // perform some action...
            $entityManager->persist($productEntity);
            $entityManager->flush();


            $id = $productEntity->getId();

            $this->addFlash(
                'success', "Product created successfully"
            );

            return new Response(
                serialize(
                    ['id' => $id, 'message' => "Product created successfully"]
                ), 200
            );        }

        $formErrors = $form->getErrors(true);
        return $this->render('/admin/product/product_create.html.twig', ['form' => $form]);
    }


    #[Route('/product/{id}/edit', name: 'product_edit')]
    public function edit(EntityManagerInterface $entityManager,
        ProductRepository $productRepository, ProductDTOMapper $productDTOMapper, Request $request,
        int $id
    ): Response {
        $product = $productRepository->find($id);


        if (!$product) {
            throw $this->createNotFoundException('No product found for id ' . $id);
        }

        $productDTO = new ProductDTO();
        $productDTO->id = $id;

        $form = $this->createForm(ProductEditForm::class, $productDTO);


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $product = $productDTOMapper->mapToEntityForEdit($form, $product);
            // perform some action...
            $entityManager->persist($product);
            $entityManager->flush();

            $id = $product->getId();

            $this->addFlash(
                'success', "Product updated successfully"
            );

            return new Response(
                serialize(
                    ['id' => $id, 'message' => "Product updated successfully"]
                ), 200
            );
        }

        return $this->render('/admin/product/product_edit.html.twig', ['form' => $form]);
    }

    #[Route('/product/{id}/display', name: 'product_display')]
    public function display(ProductRepository $productRepository, int $id): Response
    {
        $product = $productRepository->find($id);
        if (!$product) {
            throw $this->createNotFoundException('No product found for id ' . $id);
        }

        $displayParams = ['title' => 'Product',
                          'link_id'=>'id-product',
                          'editButtonLinkText' => 'Edit',
                          'fields' => [['label' => 'Name', 'propertyName' => 'name',
                                        'link_id'=>'id-display-product'],
                                       ['label' => 'Description',
                                        'propertyName' => 'description'],]];

        return $this->render(
            'admin/product/product_display.html.twig',
            ['entity' => $product, 'params' => $displayParams]
        );

    }

    #[\Symfony\Component\Routing\Attribute\Route('/product/list', name: 'product_list')]
    public function list(ProductRepository $productRepository): Response
    {

        $listGrid = ['title' => 'Product',
                     'link_id'=>'id-product',
                     'columns' => [['label' => 'Name',
                                    'propertyName' => 'name',
                                    'action' => 'display',],
                                   ['label' => 'Description', 'propertyName' => 'description'],],
                     'createButtonConfig' => ['link_id' => ' id-create-product',
                                              'function' => 'product',
                                              'anchorText' => 'Create Product']];

        $products = $productRepository->findAll();
        return $this->render(
            'admin/ui/panel/section/content/list/list.html.twig',
            ['entities' => $products, 'listGrid' => $listGrid]
        );
    }
}