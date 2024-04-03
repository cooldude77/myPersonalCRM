<?php
// src/Controller/FileController.php
namespace App\Controller\Common\File;

// ...
use App\Form\Common\File\DTO\FileFormDTO;
use App\Form\Common\File\FileCreateForm;
use App\Form\Common\File\Mapper\FileDTOMapper;
use App\Service\File\FileGeneralDirectoryPathNamer;
use App\Service\File\FileService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
                               FileDTOMapper $fileDTOMapper,
                               FileService $fileService, Request $request): Response
    {
        $fileFormDTO = new FileFormDTO();
        $form = $this->createForm(FileCreateForm::class, $fileFormDTO);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $fileEntity = $fileDTOMapper->mapToFileEntity($form->getData());

            $fileService->moveFile( $fileFormDTO->uploadedFile,$fileEntity->getName(),[]);

            $entityManager->persist($fileEntity);
            $entityManager->flush();
            return $this->redirectToRoute('common/file/success_create.html.twig');
        }

        return $this->render('common/file/create.html.twig', ['form' => $form]);
    }
}