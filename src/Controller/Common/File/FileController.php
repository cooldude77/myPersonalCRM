<?php
// src/Controller/FileController.php
namespace App\Controller\Common\File;

// ...
use App\Form\Common\File\DTO\FileFormDTO;
use App\Form\Common\File\FileCreateForm;
use App\Form\Common\File\FileUpdateForm;
use App\Form\Common\File\Mapper\FileDTOMapper;
use App\Repository\FileRepository;
use App\Service\File\FileService;
use App\Service\File\Provider\FileDirectoryPathProvider;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 *  Image guidelines :
 *
 *  Carousel :
 */
class FileController extends
    AbstractController
{
    #[Route('/file/create', name: 'file_create')]
    public function create(EntityManagerInterface    $entityManager,
                           FileDTOMapper             $fileDTOMapper,
                           FileService               $fileService,
                           FileDirectoryPathProvider $directoryPathProvider,
                           Request                   $request): Response
    {
        $fileFormDTO = new FileFormDTO();
        $form = $this->createForm(FileCreateForm::class,
            $fileFormDTO);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $fileEntity = $fileDTOMapper->mapToFileEntity($form->getData());
            $fileService->moveFile($fileFormDTO->uploadedFile,
                $fileEntity->getName(),
                $directoryPathProvider->getBaseFolderPath());

            $entityManager->persist($fileEntity);
            $entityManager->flush();
            return $this->redirectToRoute('common/file/success_create.html.twig');
        }

        return $this->render('common/file/create.html.twig',
            ['form' => $form]);
    }

    #[Route('/file/edit/{id}', name: 'file_edit')]
    public function edit(int                       $id,
                         EntityManagerInterface    $entityManager,
                         FileRepository            $fileRepository,
                         FileDTOMapper             $fileDTOMapper,
                         FileService               $fileService,
                         FileDirectoryPathProvider $directoryPathProvider,
                         Request                   $request): Response
    {
        $fileEntity = $fileRepository->findOneBy(['id' => $id]);

        $fileFormDTO = $fileDTOMapper->mapFromEntity($fileEntity);
        $form = $this->createForm(FileUpdateForm::class,
            $fileFormDTO);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $fileEntity = $fileDTOMapper->mapToFileEntity($form->getData());
            $fileService->moveFile($fileFormDTO->uploadedFile,
                $fileEntity->getName(),
                $directoryPathProvider->getBaseFolderPath());

            $entityManager->persist($fileEntity);
            $entityManager->flush();
            return $this->redirectToRoute('common/file/success_create.html.twig');
        }

        return $this->render('common/file/edit.html.twig',
            ['form' => $form, 'entity' => $fileEntity]);
    }


    #[Route('/file/list', name: 'file_list')]
    public function list(FileRepository $fileRepository): Response
    {

        $files = $fileRepository->findAll();

        $listGrid = ['title' => 'File', 'columns' => [['label' => 'Your fileName', 'propertyName' => 'yourFileName', 'action' => 'display'], ['label' => 'FileName', 'propertyName' => 'name'],


        ], 'create_button' => ['targetRoute' => 'file_create', 'redirectRoute' => 'admin_panel']];

        return $this->render('admin/ui/panel/section/content/list/list.html.twig',
            ['entities' => $files, 'listGrid' => $listGrid]);
    }

    #[Route('/file/display/{id}', name: 'file_display')]
    public function display(FileRepository $fileRepository,
                            int            $id): Response
    {
        $file = $fileRepository->find($id);
        if (!$file) {
            throw $this->createNotFoundException('No file found for id ' . $id);
        }

        $displayParams = ['title' => 'File', 'editButtonLinkText' => 'Edit', 'fields' => [['label' => 'Your File Name', 'propertyName' => 'yourFileName'], ['label' => 'Name', 'propertyName' => 'name'],]];

        return $this->render('common/file/display.html.twig',
            ['entity' => $file, 'params' => $displayParams]);

    }

    #[Route('/file/fetch/{id}', name: 'file_fetch')]
    public function fetch(int                       $id,
                          FileRepository            $fileRepository,
                          FileDirectoryPathProvider $directoryPathProvider,
                          FileService               $fileService): Response
    {
        $fileEntity = $fileRepository->findOneBy(['id' => $id]);
        $path = $directoryPathProvider->getFullPathForImageFile($fileEntity->getName());

        $file = file_get_contents($path);

        $headers = array('Content-Type' => $fileEntity->getType()->getMimeType(), 'Content-Disposition' => 'inline; filename="' . $fileEntity->getName() . '"');
        return new Response($file,
            200,
            $headers);

    }

    #[Route('/file/path/{name}', name: 'file_path_by_name')]
    public function getFilePath(string                       $name,
                                FileRepository            $fileRepository,
                                FileDirectoryPathProvider $directoryPathProvider,
                                FileService               $fileService): Response
    {

        $fileEntity = $fileRepository->findOneBy(['name' => $name]);
        $path = $directoryPathProvider->getFullPathForImageFile($name);

        $file = file_get_contents($path);

        return new BinaryFileResponse($path);

    }
}