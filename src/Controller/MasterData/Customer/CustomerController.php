<?php
// src/Controller/CustomerController.php
namespace App\Controller\MasterData\Customer;

// ...
use App\Form\Admin\Customer\CustomerEditForm;
use App\Form\Admin\Customer\DTO\CustomerDTO;
use App\Form\MasterData\Customer\CustomerCreateForm;
use App\Repository\CustomerRepository;
use App\Service\Customer\Mapper\CustomerDTOMapper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CustomerController extends AbstractController
{

    #[\Symfony\Component\Routing\Attribute\Route('/Customer/create', 'Customer_create')]
    public function create(CustomerDTOMapper $CustomerDTOMapper,
        EntityManagerInterface $entityManager, Request $request
    ): Response {
        $CustomerDTO = new CustomerDTO();
        $form = $this->createForm(
            CustomerCreateForm::class, $CustomerDTO
        );

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $CustomerEntity = $CustomerDTOMapper->mapToEntityForCreate($form);


            // perform some action...
            $entityManager->persist($CustomerEntity);
            $entityManager->flush();


            $id = $CustomerEntity->getId();

            $this->addFlash(
                'success', "Customer created successfully"
            );

            return new Response(
                serialize(
                    ['id' => $id, 'message' => "Customer created successfully"]
                ), 200
            );        }

        $formErrors = $form->getErrors(true);
        return $this->render('/admin/Customer/Customer_create.html.twig', ['form' => $form]);
    }


    #[Route('/Customer/{id}/edit', name: 'Customer_edit')]
    public function edit(EntityManagerInterface $entityManager,
        CustomerRepository $CustomerRepository, CustomerDTOMapper $CustomerDTOMapper, Request $request,
        int $id
    ): Response {
        $Customer = $CustomerRepository->find($id);


        if (!$Customer) {
            throw $this->createNotFoundException('No Customer found for id ' . $id);
        }

        $CustomerDTO = new CustomerDTO();
        $CustomerDTO->id = $id;

        $form = $this->createForm(CustomerEditForm::class, $CustomerDTO);


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $Customer = $CustomerDTOMapper->mapToEntityForEdit($form, $Customer);
            // perform some action...
            $entityManager->persist($Customer);
            $entityManager->flush();

            $id = $Customer->getId();

            $this->addFlash(
                'success', "Customer updated successfully"
            );

            return new Response(
                serialize(
                    ['id' => $id, 'message' => "Customer updated successfully"]
                ), 200
            );
        }

        return $this->render('/admin/Customer/Customer_edit.html.twig', ['form' => $form]);
    }

    #[Route('/Customer/{id}/display', name: 'Customer_display')]
    public function display(CustomerRepository $CustomerRepository, int $id): Response
    {
        $Customer = $CustomerRepository->find($id);
        if (!$Customer) {
            throw $this->createNotFoundException('No Customer found for id ' . $id);
        }

        $displayParams = ['title' => 'Customer',
                          'link_id'=>'id-Customer',
                          'editButtonLinkText' => 'Edit',
                          'fields' => [['label' => 'Name', 'propertyName' => 'name',
                                        'link_id'=>'id-display-Customer'],
                                       ['label' => 'Description',
                                        'propertyName' => 'description'],]];

        return $this->render(
            'admin/Customer/Customer_display.html.twig',
            ['entity' => $Customer, 'params' => $displayParams]
        );

    }

    #[\Symfony\Component\Routing\Attribute\Route('/Customer/list', name: 'Customer_list')]
    public function list(CustomerRepository $CustomerRepository): Response
    {

        $listGrid = ['title' => 'Customer',
                     'link_id'=>'id-Customer',
                     'columns' => [['label' => 'Name',
                                    'propertyName' => 'name',
                                    'action' => 'display',],
                                   ['label' => 'Description', 'propertyName' => 'description'],],
                     'createButtonConfig' => ['link_id' => ' id-create-Customer',
                                              'function' => 'Customer',
                                              'anchorText' => 'Create Customer']];

        $Customers = $CustomerRepository->findAll();
        return $this->render(
            'admin/ui/panel/section/content/list/list.html.twig',
            ['entities' => $Customers, 'listGrid' => $listGrid]
        );
    }
}