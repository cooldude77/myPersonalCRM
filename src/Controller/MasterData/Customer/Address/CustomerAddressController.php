<?php
// src/Controller/CustomerController.php
namespace App\Controller\MasterData\Customer\Address;

// ...
use App\Form\MasterData\Customer\Address\DTO\CustomerAddressDTO;
use App\Form\MasterData\Customer\Address\CustomerAddressCreateForm;
use App\Form\MasterData\Customer\Address\CustomerAddressEditForm;
use App\Repository\CustomerAddressRepository;
use App\Service\MasterData\Customer\Address\CustomerAddressDTOMapper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CustomerAddressController extends AbstractController
{

    #[Route('/product/attribute/{id}/value/create', name: 'product_attribute_value_create')]
    public function create(int $id, CustomerAddressDTOMapper $mapper,
        EntityManagerInterface $entityManager, Request $request
    ): Response {
        $customerAddressDTO = new CustomerAddressDTO();
        $customerAddressDTO->customerId = $id;

        $form = $this->createForm(
            CustomerAddressCreateForm::class, $customerAddressDTO
        );

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $customerAddress = $mapper->mapDtoToEntityForCreate($form->getData());

            $entityManager->persist($customerAddress);
            $entityManager->flush();

            $this->addFlash(
                'success', "Product Attribute created successfully"
            );

            $id = $customerAddress->getId();

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
    public function edit(int $id, CustomerAddressDTOMapper $mapper,
        EntityManagerInterface $entityManager,
        CustomerAddressRepository $customerAddressRepository, Request $request
    ): Response {
        $customerAddressDTO = new CustomerAddressDTO();

        $customerAddressEntity = $customerAddressRepository->find($id);

        $form = $this->createForm(CustomerAddressEditForm::class, $customerAddressDTO);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $customerEntity = $mapper->mapDtoToEntityForUpdate(
                $form->getData(), $customerAddressEntity
            );

            $entityManager->persist($customerEntity);
            $entityManager->flush();


            $id = $customerEntity->getId();
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
    public function list(int $id, CustomerAddressRepository $customerAddressRepository
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

        $customerAddresss = $customerAddressRepository->findBy(
            ['customer' => $id]
        );
        return $this->render(
            'admin/ui/panel/section/content/list/list.html.twig',
            ['entities' => $customerAddresss, 'listGrid' => $listGrid]
        );
    }

}