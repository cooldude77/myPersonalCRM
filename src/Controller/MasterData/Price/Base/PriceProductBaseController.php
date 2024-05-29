<?php
// src/Controller/PriceController.php
namespace App\Controller\MasterData\Price\Base;

// ...
use App\Form\MasterData\Price\DTO\PriceBaseDTO;
use App\Form\MasterData\Price\Mapper\PriceBaseDTOMapper;
use App\Form\MasterData\Price\PriceBaseCreateForm;
use App\Form\MasterData\Price\PriceBaseEditForm;
use App\Repository\PriceProductBaseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class PriceProductBaseController extends AbstractController
{
    #[\Symfony\Component\Routing\Annotation\Route('/price/base/create', name: 'price_base_create')]
    public function create(PriceBaseDTOMapper $mapper, EntityManagerInterface $entityManager,
        Request $request
    ): Response {
        $priceProductBaseDTO = new PriceBaseDTO();

        $form = $this->createForm(PriceBaseCreateForm::class, $priceProductBaseDTO);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $priceProductBase = $mapper->mapDtoToEntity($form->getData());

            $entityManager->persist($priceProductBase);
            $entityManager->flush();

            $this->addFlash(
                'success', "Product created successfully"
            );

            $id = $priceProductBase->getId();
            $this->addFlash(
                'success', "Product Attribute created successfully"
            );

            return new Response(
                serialize(
                    ['id' => $id, 'message' => "Product Attribute created successfully"]
                ), 200
            );
        }

        return $this->render(
            '/admin/ui/panel/section/content/create/create.html.twig', ['form' => $form]
        );

    }


    #[\Symfony\Component\Routing\Attribute\Route('/price/base/{id}/edit', name: 'price_base_edit')]
    public function edit(int $id, PriceBaseDTOMapper $mapper,
        EntityManagerInterface $entityManager,
        PriceProductBaseRepository $priceProductBaseRepository, Request $request
    ): Response {
        $priceProductBaseDTO = new PriceBaseDTO();

        $priceBase = $priceProductBaseRepository->find($id);

        $form = $this->createForm(PriceBaseEditForm::class, $priceProductBaseDTO);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $priceBase = $mapper->mapDtoToEntityForEdit(
                $form->getData(), $priceBase
            );

            $entityManager->persist($priceBase);
            $entityManager->flush();

            $this->addFlash(
                'success', "Product Attribute Value updated successfully"
            );

            return new Response(
                serialize(
                    ['id' => $id, 'message' => "Product Attribute Value updated successfully"]
                ), 200
            );
        }

        return $this->render(
            'admin/ui/panel/section/content/edit/edit.html.twig', ['form' => $form]
        );

    }


}