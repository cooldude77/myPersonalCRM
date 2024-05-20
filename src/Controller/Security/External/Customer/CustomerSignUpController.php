<?php

namespace App\Controller\Security\External\Customer;

use App\Entity\Customer;
use App\Entity\User;
use App\Form\Security\User\UserSignUpSimpleForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class CustomerSignUpController extends AbstractController
{
    #[Route('/signup', name: 'user_customer_sign_up')]
    public function signUp(Request $request,
        UserPasswordHasherInterface $userPasswordHasher,
        EntityManagerInterface $entityManager): Response
    {
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

            return $this->redirectToRoute('admin_panel');
        }

        return $this->render('security/external/user/sign_up.html.twig', [
            'form' => $form,
        ]);
    }
}
