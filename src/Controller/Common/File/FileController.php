<?php
// src/Controller/FileController.php
namespace App\Controller\Common\File;

// ...
use App\Entity\File;
use App\Form\Common\File\FileCreateForm;
use App\Repository\FileRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FileController extends AbstractController
{
    #[Route('/file/create', name: 'file_create')]
    public function createFile( EntityManagerInterface  $entityManager,Request $request): Response
    {
        $file = new File();

        $form = $this->createForm(FileCreateForm::class, $file);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var File $file */
            $file = $form->getData();
            $fileHandle = $form->get('uploadedFile')->getData();
            $fileName = $file->getName().'.'.$fileHandle->guessExtension();

            //$fileHandle->move($this->getParameter('/tmp'), $fileName);
            if($fileHandle->move('/var/www/html/temp', $fileName)){

                $file->setName($fileName);
                $entityManager->persist($file);
                $entityManager->flush();

                return $this->redirectToRoute('common/file/success_create.html.twig');
            }


        }
        return $this->render('common/file/create.html.twig', ['form' => $form]);
    }

}