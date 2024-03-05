<?php
// src/Controller/CustomerController.php
namespace App\Controller\Admin\Customer;

// ...
use App\Entity\Customer;
use App\Form\Admin\Customer\CustomerCreateForm;
use App\Repository\CustomerRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CustomerController extends AbstractController
{
    #[Route('/customer/create', name: 'create_customer')]
    public function createCustomer(EntityManagerInterface $entityManager, Request $request): Response
    {
        $type = new Customer();

        $form = $this->createForm(CustomerCreateForm::class, $type);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // perform some action...
            $entityManager->persist($form->getData());
            $entityManager->flush();

            return $this->redirectToRoute('admin/customer/success_create.html.twig');
        }
        return $this->render('admin/customer/create.html.twig', ['form' => $form]);
    }


    #[Route('/customer/edit/{id}', name: 'customer_edit')]
    public function update(CustomerRepository $customerRepository, int $id): Response
    {
        $customer = $customerRepository->find($id);


        if (!$customer) {
            throw $this->createNotFoundException(
                'No customer found for id ' . $id
            );
        }

        $customer->setCustomerCode('New .... ');
        $customerRepository->getEntityManager()->flush($customer);

        return new Response('Check out this updated customer: ' . $customer->getCustomerCode());

        // or render a template
        // in the template, print things with {{ customer.name }}
        // return $this->render('customer/show.html.twig', ['customer' => $customer]);
    }

    #[Route('/customer/list', name: 'customer_list')]
    public function list(ProductRepository $productRepository, int $id): Response
    {
        $product = $productRepository->find($id);

        return new Response('Check out this updated product: ' . $product->getProductDescription());

        // or render a template
        // in the template, print things with {{ product.name }}
        // return $this->render('product/show.html.twig', ['product' => $product]);
    }
}