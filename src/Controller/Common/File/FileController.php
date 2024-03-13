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
use Symfony\Component\Routing\Attribute\Route;

class FileController extends AbstractController
{
    #[Route('/file/create', name: 'file_create')]
    public function createFile(EntityManagerInterface $entityManager, Request $request): Response
    {
        $file = new File();

        $form = $this->createForm(FileCreateForm::class, $file);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // perform some action...
            //        $entityManager->persist($form->getData());
            //       $entityManager->flush();

            $fileHandle = $form->get('uploadedFile')->getData();
            $fileName = md5(uniqid()) . '.' . $fileHandle->guessExtension();
            //$fileHandle->move($this->getParameter('/tmp'), $fileName);
            $fileHandle->move('/var/www/html/temp', $fileName);

            return $this->redirectToRoute('common/file/success_create.html.twig');
        }
        return $this->render('common/file/create.html.twig', ['form' => $form]);
    }


}