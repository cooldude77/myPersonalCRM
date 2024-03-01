<?php
// src/Controller/OrderItemController.php
namespace App\Controller\Common\Order\Item;

// ...
use App\Entity\OrderItem;
use App\Form\Common\Order\Item\OrderItemCreateForm;
use App\Repository\OrderItemRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderItemController extends AbstractController
{
    #[Route('/orderItem/create', name: 'create_orderItem')]
    public function createOrderItem(EntityManagerInterface $entityManager, Request $request): Response
    {
        $type = new OrderItem();

        $form = $this->createForm(OrderItemCreateForm::class, $type);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // perform some action...
            $entityManager->persist($form->getData());
            $entityManager->flush();

            return $this->redirectToRoute('common\Order\orderItem/success_create.html.twig');
        }
        return $this->render('common\Order/orderItem/create.html.twig', ['form' => $form]);
    }


    #[Route('/orderItem/edit/{id}', name: 'orderItem_edit')]
    public function update(OrderItemRepository $orderItemRepository, int $id): Response
    {
        $orderItem = $orderItemRepository->find($id);


        if (!$orderItem) {
            throw $this->createNotFoundException(
                'No orderItem found for id ' . $id
            );
        }

        $orderItem->setOrderItemDescription('New .... ');
        $orderItemRepository->getEntityManager()->flush($orderItem);

        return new Response('Check out this updated orderItem: ' . $orderItem->getOrderItemDescription());

        // or render a template
        // in the template, print things with {{ orderItem.name }}
        // return $this->render('orderItem/show.html.twig', ['orderItem' => $orderItem]);
    }
}