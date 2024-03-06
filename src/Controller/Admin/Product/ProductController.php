<?php
// src/Controller/ProductController.php
namespace App\Controller\Admin\Product;

// ...
use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProductController extends AbstractCrudController
{
    /*
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
            $products = $productRepository->findAll();

            return $this->render('admin/product/list.html.twig', ['products' => $products]);
        }
    */
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('productCode');
        yield TextField::new('productDescription');
        yield AssociationField::new('category');
    }
}