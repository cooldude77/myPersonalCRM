<?php

namespace App\Controller\Admin\Product\Attribute\Value;

use App\Form\Admin\Product\Attribute\Value\DTO\ProductAttributeValueDTO;
use App\Form\Admin\Product\Attribute\Value\ProductAttributeValueCreateForm;
use App\Form\Admin\Product\Attribute\Value\ProductAttributeValueEditForm;
use App\Repository\ProductAttributeValueRepository;
use App\Service\Product\Attribute\Value\ProductAttributeValueDTOMapper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductAttributeValueController extends AbstractController
{

    #[Route('/product/attribute/{id}/value/create', name: 'product_attribute_value_create')]
    public function create(int $id, ProductAttributeValueDTOMapper $mapper,
        EntityManagerInterface $entityManager, Request $request
    ): Response {
        $productAttributeValueDTO = new ProductAttributeValueDTO();
        $productAttributeValueDTO->productAttributeId = $id;

        $form = $this->createForm(
            ProductAttributeValueCreateForm::class, $productAttributeValueDTO
        );

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $productAttributeValue = $mapper->mapDtoToEntityForCreate($form->getData());

            $entityManager->persist($productAttributeValue);
            $entityManager->flush();

            $this->addFlash(
                'success', "Product Attribute created successfully"
            );

            $id = $productAttributeValue->getId();

            return new Response(
                serialize(
                    ['id' => $id, 'message' => "Product Attribute created successfully"]
                ), 200
            );

        }

        return $this->render(
            '/admin/ui/panel/section/content/create/create.html.twig', ['form' => $form]
        );

    }


    #[\Symfony\Component\Routing\Attribute\Route('/product/attribute/value/{id}/edit', name: 'product_attribute_value_edit')]
    public function edit(int $id, ProductAttributeValueDTOMapper $mapper,
        EntityManagerInterface $entityManager,
        ProductAttributeValueRepository $productAttributeValueRepository, Request $request
    ): Response {
        $productAttributeValueDTO = new ProductAttributeValueDTO();

        $productAttributeValueEntity = $productAttributeValueRepository->find($id);

        $form = $this->createForm(ProductAttributeValueEditForm::class, $productAttributeValueDTO);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $productAttributeEntity = $mapper->mapDtoToEntityForUpdate(
                $form->getData(), $productAttributeValueEntity
            );

            $entityManager->persist($productAttributeEntity);
            $entityManager->flush();


            $id = $productAttributeEntity->getId();
            $this->addFlash(
                'success', "Product Attribute Value updated successfully"
            );

            return new Response(
                serialize(
                    ['id' => $id, 'message' => "Product Attribute Value updated successfully"]
                ), 200
            );
        }

        return $this->render(
            '/admin/ui/panel/section/content/edit/edit.html.twig', ['form' => $form]
        );

    }


    #[Route("/product/attribute/{id}/value/list", name: 'product_attribute_value_list')]
    public function list(int $id, ProductAttributeValueRepository $productAttributeValueRepository
    ): Response {

        $listGrid = ['title' => 'Product Attribute Values',
                     'link_id' => 'id-product-attribute-value',
                     'columns' => [['label' => 'Name',
                                    'propertyName' => 'name',
                                    'action' => 'display'],
                                   ['label' => 'value',
                                    'propertyName' => 'value'],],
                     'createButtonConfig' => ['link_id' => 'id-create-product-attribute-value',
                                              'function' => 'product_attribute_value',
                                              'anchorText' => 'Create Product Attribute Value']];

        $productAttributeValues = $productAttributeValueRepository->findBy(
            ['productAttribute' => $id]
        );
        return $this->render(
            'admin/ui/panel/section/content/list/list.html.twig',
            ['entities' => $productAttributeValues, 'listGrid' => $listGrid]
        );
    }

}