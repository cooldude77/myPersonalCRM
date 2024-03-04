<?php
// src/Controller/FileController.php
namespace App\Controller\Common\File;

// ...
use App\Entity\File;
use App\Form\Common\File\FileCreateForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FileController extends AbstractController
{
    #[Route('/file/create', name: 'file_create')]
    public function createFile(EntityManagerInterface $entityManager, Request $request): Response
    {
        $type = new File();

        $form = $this->createForm(FileCreateForm::class, $type);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // perform some action...
            $entityManager->persist($form->getData());
            $entityManager->flush();

            return $this->redirectToRoute('common/file/success_create.html.twig');
        }
        return $this->render('common/file/create.html.twig', ['form' => $form]);
    }


}