<?php
// src/Controller/ProductController.php
namespace App\Controller\Admin\User;

// ...
use App\Entity\User;
use App\Form\Admin\User\UserForm;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user/create', name: 'create_user')]
    public function createUser(UserRepository $repository, Request $request): Response
    {
        $user = new User();

        $form = $this->createForm(UserForm::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // perform some action...

            return $this->redirectToRoute('task_success');
        }


        return $this->render('admin/user/create.html.twig', [
            'form' => $form,
        ]);

    }


}