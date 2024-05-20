<?php

namespace App\Controller\Security\External\Customer;

use App\Entity\Customer;
use App\Entity\User;
use App\Form\MasterData\Customer\DTO\CustomerDTO;
use App\Form\Security\User\UserSignUpAdvancedForm;
use App\Form\Security\User\UserSignUpSimpleForm;
use App\Service\MasterData\Customer\Mapper\CustomerDTOMapper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class CustomerSignUpController extends AbstractController
{

    /**
     * @param Request                     $request
     * @param UserPasswordHasherInterface $userPasswordHasher
     * @param EntityManagerInterface      $entityManager
     *
     * @return Response
     *
     * To be called when user quickly wants to sign up
     */
    #[Route('/signup', name: 'user_customer_sign_up')]
    public function signUp(Request $request,
        UserPasswordHasherInterface $userPasswordHasher,
        EntityManagerInterface $entityManager
    ): Response {
        $user = new User();
        $form = $this->createForm(UserSignUpSimpleForm::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $user->setRoles(['ROLE_CUSTOMER']);

            $customer = new Customer();
            $customer->setUser($user);
            $customer->setEmail($user->getLogin());

            $entityManager->persist($user);
            $entityManager->persist($customer);
            $entityManager->flush();

            // do anything else you need here, like send an email
            if ($request->get('_redirect_after_success') == null) {
                return $this->redirectToRoute('home');
            } else {
                return $this->redirectToRoute($request->get('_redirect_after_success'));
            }
        }

        return $this->render('security/external/user/sign_up_page.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * @param CustomerDTOMapper      $customerDTOMapper
     * @param EntityManagerInterface $entityManager
     *
     * @param Request                $request
     *
     * @return Response
     *
     * To be called when user is willing to add extra details for example from a checkout form
     * @throws NoRedirectParameterSetException
     */
    #[Route('/signup/advanced', name: 'user_customer_sign_up_advanced')]
    // Todo: Make redirect_after_success mandatory in route
    public function signUpAdvanced(CustomerDTOMapper $customerDTOMapper,
        EntityManagerInterface $entityManager, Request $request
    ): Response {
        if ($request->get('_redirect_after_success') == null) {
            throw new NoRedirectParameterSetException($request->getUri());
        }

        $customerDTO = new CustomerDTO();
        $form = $this->createForm(
            UserSignUpAdvancedForm::class, $customerDTO
        );

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $customerEntity = $customerDTOMapper->mapToEntityForCreate($form);


            // perform some action...
            $entityManager->persist($customerEntity);
            $entityManager->flush();


            $id = $customerEntity->getId();

            $this->addFlash(
                'success', "Sign Up Successful"
            );

            return $this->redirectToRoute($request->get('_redirect_after_success'));

        }

        return $this->render('master_data/customer/customer_create.html.twig', ['form' => $form]);

    }
}
