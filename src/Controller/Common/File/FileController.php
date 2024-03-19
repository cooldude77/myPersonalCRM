<?php
// src/Controller/FileController.php
namespace App\Controller\Common\File;

// ...
use App\Entity\File;
use App\Form\Common\File\DTO\FileFormDTO;
use App\Form\Common\File\FileCreateForm;
use App\Repository\FileRepository;
use App\Service\File\FileDirectoryService;
use App\Service\File\FileService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Attribute\Route;

/**
 *  Image guidelines :
 *
 *  Carousel : 
 */
class FileController extends AbstractController
{
    #[Route('/file/create', name: 'file_create')]
    public function createFile(EntityManagerInterface $entityManager,
                               FileService            $fileService, Request $request,
                               FileDirectoryService   $fileDirectoryService): Response
    {
        $fileFormDTO = new FileFormDTO();
        $form = $this->createForm(FileCreateForm::class, $fileFormDTO);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $fileEntity = $fileService->mapFileEntity($form->getData());
            $path = $fileDirectoryService->getGeneralFileFullPath();
            $fileHandle = $form->getData('uploadedFile')->uploadedFile;
            $fileService->move( $fileHandle,$fileEntity->getName(), $path);

            $entityManager->persist($fileEntity);
            $entityManager->flush();
            return $this->redirectToRoute('common/fileFormDTO/success_create.html.twig');
        }

        return $this->render('common/file/create.html.twig', ['form' => $form]);
    }
}