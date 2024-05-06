<?php
// src/Controller/ProductController.php
namespace App\Controller\Admin\Product\Attribute;

// ...
use App\Form\Admin\Product\Attribute\DTO\ProductAttributeDTO;
use App\Form\Admin\Product\Attribute\ProductAttributeCreateForm;
use App\Form\Admin\Product\Attribute\ProductAttributeEditForm;
use App\Repository\ProductAttributeRepository;
use App\Service\Product\Attribute\ProductAttributeDTOMapper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductAttributeController extends AbstractController
{
    #[Route('/product/attribute/create', name: 'product_attribute_create')]
    public function create(ProductAttributeDTOMapper $mapper, EntityManagerInterface $entityManager,
        Request $request
    ): Response {
        $productAttributeDTO = new ProductAttributeDTO();

        $form = $this->createForm(ProductAttributeCreateForm::class, $productAttributeDTO);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $productAttribute = $mapper->mapDtoToEntity($form->getData());

            $entityManager->persist($productAttribute);
            $entityManager->flush();

            if ($request->get('_redirect_upon_success_url')) {
                $this->addFlash(
                    'success', "Product created successfully"
                );

                $id = $productAttribute->getId();
                $success_url = $request->get('_redirect_upon_success_url') . "&id=$id";

                return $this->redirect($success_url);
            }
            return $this->render(
                '/common/miscellaneous/success/create.html.twig',
                ['message' => 'Product successfully created']
            );
        }

        return $this->render(
            '/admin/ui/panel/section/content/create/create.html.twig', ['form' => $form]
        );

    }



    #[\Symfony\Component\Routing\Attribute\Route('/product/attribute/{id}/edit', name: 'product_attribute_edit')]
    public function edit(
        int $id,
        ProductAttributeDTOMapper $mapper, EntityManagerInterface $entityManager,
        ProductAttributeRepository $productAttributeRepository,
        Request $request
    ): Response {
        $productAttributeDTO = new ProductAttributeDTO();

        $productAttributeEntity =  $productAttributeRepository->find($id);

        $form = $this->createForm(ProductAttributeEditForm::class, $productAttributeDTO);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $productAttributeEntity = $mapper->mapDtoToEntityForEdit($form->getData(),$productAttributeEntity);

            $entityManager->persist($productAttributeEntity);
            $entityManager->flush();

            if ($request->get('_redirect_upon_success_url')) {
                $this->addFlash(
                    'success', "Product created successfully"
                );

                $id = $productAttributeEntity->getId();
                $success_url = $request->get('_redirect_upon_success_url') . "&id=$id";

                return $this->redirect($success_url);
            }
            return $this->render(
                '/common/miscellaneous/success/create.html.twig',
                ['message' => 'Product successfully created']
            );
        }

        return $this->render(
            '/admin/ui/panel/section/content/create/create.html.twig', ['form' => $form]
        );

    }


    #[Route('/product/attribute/list', name: 'product_attribute_list')]
    public function list(ProductAttributeRepository $productAttributeRepository): Response
    {

        $listGrid = ['title' => 'Product Attribute',
                     'link_id'=>'id-product-attribute',
                     'columns' => [['label' => 'Name',
                                    'propertyName' => 'name',
                                    'action' => 'display'],
                                   ['label' => 'Description',
                                    'propertyName' => 'description'],],
                     'createButtonConfig' => [
                         'link_id'=>'id-create-product_attribute',
                         'function' => 'product_attribute',
                                              'anchorText' => 'Create Product Attribute']];

        $productAttributes = $productAttributeRepository->findAll();
        return $this->render(
            'admin/ui/panel/section/content/list/list.html.twig',
            ['entities' => $productAttributes, 'listGrid' => $listGrid]
        );
    }

}