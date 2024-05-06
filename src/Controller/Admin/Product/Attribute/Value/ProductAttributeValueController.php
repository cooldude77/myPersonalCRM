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

            if ($request->get('_redirect_upon_success_url')) {
                $this->addFlash(
                    'success', "Product created successfully"
                );

                $id = $productAttributeValue->getId();
                $success_url = $request->get('_redirect_upon_success_url') . "&id=$id";

                return $this->redirect($success_url);
            }
            return $this->render(
                '/common/miscellaneous/success/create.html.twig',
                ['message' => 'Product successfully created']
            );
        }

        $formErrors = $form->getErrors(true);
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


    #[Route("/product/attribute/{id}/value/list", name: 'product_attribute_value_list')]
    public function list(int $id, ProductAttributeValueRepository $productAttributeValueRepository
    ): Response {

        $listGrid = ['title' => 'Product Attribute Values',
                     'columns' => [
                         ['label' => 'Name',
                          'propertyName' => 'name',
                          'action' => 'display'],
                         ['label' => 'value',
                          'propertyName' => 'value'],
                     ],
                     'createButtonConfig' => [
                         'function' => 'product_attribute_value',
                         'anchorText' => 'Create Product Attribute Value']
        ];

        $productAttributeValues = $productAttributeValueRepository->findBy(
            ['productAttribute' => $id]
        );
        return $this->render(
            'admin/ui/panel/section/content/list/list.html.twig',
            ['entities' => $productAttributeValues, 'listGrid' => $listGrid]
        );
    }

}