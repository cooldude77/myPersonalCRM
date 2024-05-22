<?php
// src/Controller/PaymentTypeController.php
namespace App\Controller\Module\WebShop\External\Payment;

// ...
use App\Form\Module\WebShop\External\PaymentType\PaymentTypeChoiceForm;
use App\Service\Module\WebShop\External\Payment\PaymentService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PaymentTypeController extends AbstractController
{

    #[\Symfony\Component\Routing\Attribute\Route('/web_shop/payment_type/choose', 'web_shop_payment_type_choose')]
    public function create(
        EntityManagerInterface $entityManager,
        PaymentService $paymentService,
        Request $request
    ): Response {

        $form = $this->createForm(PaymentTypeChoiceForm::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $orderObject = $paymentService->createNewOrder();

            // save order to database
            $entityManager->persist($orderObject->getHeader());
            $entityManager->persist($orderObject->getItems());
            $entityManager->persist($orderObject->getAddresses())
            ;

            //todo: validate payment details
            // verify payment done
            // create

            $paymentTransactionId = "dfsdfaasasa";
            // upon success

            $orderPaymentDetails = $paymentService->createPaymentEntity(
                $orderObject->getHeader()->getId(),
                $paymentTransactionId
            );

            $entityManager->persist($orderPaymentDetails);

            $paymentService->postOrderSuccessCleanup();

            return $this->redirectToRoute('web_shop_order_complete_details', ['id' =>
                                                                                  $orderObject
                                                                                      ->getHeader()
                                                                                      ->getId()]);
        }
        return $this->render('common/payment_type/payment_type_create.html.twig', ['form' => $form]
        );
    }


}