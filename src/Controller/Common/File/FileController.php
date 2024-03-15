<?php
// src/Controller/FileController.php
namespace App\Controller\Common\File;

// ...
use App\Entity\File;
use App\Form\Common\File\DTO\FileFormDTO;
use App\Form\Common\File\FileCreateForm;
use App\Repository\FileRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Attribute\Route;

class FileController extends AbstractController
{
    #[Route('/file/create', name: 'file_create')]
    public function createFile( EntityManagerInterface  $entityManager,Request $request): Response
    {
        $fileFormDTO = new FileFormDTO();

        $form = $this->createForm(FileCreateForm::class, $fileFormDTO);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var FileFormDTO $fileFormDTO */
            $fileFormDTO = $form->getData();
            $fileHandle = $form->get('uploadedFile')->getData();
            $fileName = $fileFormDTO->name.'.'.$fileHandle->guessExtension();

            //$fileHandle->move($this->getParameter('/tmp'), $fileName);
            if($fileHandle->move('/var/www/html/temp', $fileName)){

                $fileFormDTO->name = $fileName;
                $entityManager->persist($fileFormDTO);
                $entityManager->flush();

                return $this->redirectToRoute('common/fileFormDTO/success_create.html.twig');
            }


        }
        return $this->render('common/file/create.html.twig', ['form' => $form]);
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FileFormDTO::class
        ]);
    }
}