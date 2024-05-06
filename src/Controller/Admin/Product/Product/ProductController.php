<?php
// src/Controller/ProductController.php
namespace App\Controller\Admin\Product\Product;

// ...
use App\Config\Admin\ProductFieldList;
use App\Entity\Category;
use App\Entity\Product;
use App\Form\Admin\Product\ProductCreateForm;
use App\Form\Admin\Product\DTO\ProductDTO;
use App\Form\Admin\Product\ProductEditForm;
use App\Repository\ProductRepository;
use App\Service\Product\Mapper\ProductDTOMapper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{

    #[\Symfony\Component\Routing\Attribute\Route('/product/create', 'product_create')]
    public function create(ProductDTOMapper $productDTOMapper,EntityManagerInterface $entityManager,Request $request): Response
    {
        $productDTO = new ProductDTO();
        $form = $this->createForm(ProductCreateForm::class,
            $productDTO);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {



            $productEntity = $productDTOMapper->mapToEntityForCreate($form);


            // perform some action...
            $entityManager->persist($productEntity);
            $entityManager->flush();

            if ($request->get('_redirect_upon_success_url')) {
                $this->addFlash('success',
                    "Product created successfully");

                $id = $productEntity->getId();
                $success_url = $request->get('_redirect_upon_success_url') . "&id=$id";

                return $this->redirect($success_url);
            }
            return $this->render('/common/miscellaneous/success/create.html.twig',
                ['message' => 'Product successfully created']);
        }

        $formErrors = $form->getErrors(true);
        return $this->render('/admin/product/product_create.html.twig', ['form' => $form]);
    }


    #[\Symfony\Component\Routing\Annotation\Route('/product/{id}/edit', name: 'product_edit')]
    public function edit(EntityManagerInterface $entityManager,
                         ProductRepository     $productRepository,
                         ProductDTOMapper $productDTOMapper,
                         Request                $request,
                         int                    $id): Response
    {
        $product = $productRepository->find($id);


        if (!$product) {
            throw $this->createNotFoundException('No product found for id ' . $id);
        }

        $productDTO = new ProductDTO();
        $productDTO->id = $id;

        $form = $this->createForm(ProductEditForm::class, $productDTO);


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $product = $productDTOMapper->mapToEntityForEdit($form,$product);
            // perform some action...
            $entityManager->persist($product);
            $entityManager->flush();

            if ($request->get('_redirect_upon_success_url')) {
                $this->addFlash('success',
                    "Product created successfully");

                $id = $product->getId();
                $success_url = $request->get('_redirect_upon_success_url') . "&id=$id";

                return $this->redirect($success_url);
            }
            return $this->render('/common/miscellaneous/success/create.html.twig',
                ['message' => 'Product successfully updated']);
        }

        return $this->render('/admin/product/product_edit.html.twig',
            ['form' => $form]);
    }

    #[Route('/product/{id}/display', name: 'product_display')]
    public function display(ProductRepository $productRepository,
                            int                $id): Response
    {
        $product = $productRepository->find($id);
        if (!$product) {
            throw $this->createNotFoundException('No product found for id ' . $id);
        }

        $displayParams = ['title' => 'Product', 'editButtonLinkText' => 'Edit', 'fields' => [['label' => 'Name', 'propertyName' => 'name'], ['label' => 'Description', 'propertyName' => 'description'],]];

        return $this->render('admin/product/product_display.html.twig',
            ['entity' => $product, 'params' => $displayParams]);

    }

    #[\Symfony\Component\Routing\Attribute\Route('/product/list', name: 'product_list')]
    public function list(ProductRepository $productRepository): Response
    {

        $listGrid = [
            'title' => 'Product',
            'columns' => [
                ['label' => 'Name', 'propertyName' => 'name', 'action' => 'display'],
                ['label' => 'Description', 'propertyName' => 'description'],
            ],
            'createButtonConfig' => [
                'function' => 'product',
                'anchorText' => 'Create Product'
            ]];

        $products = $productRepository->findAll();
        return $this->render('admin/ui/panel/section/content/list/list.html.twig',
            ['entities' => $products, 'listGrid' => $listGrid]);
    }
}