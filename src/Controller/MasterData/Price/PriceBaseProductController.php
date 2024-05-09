<?php
// src/Controller/PriceController.php
namespace App\Controller\MasterData\Price;

// ...
use App\Form\MasterData\Price\DTO\PriceBaseDTO;
use App\Form\MasterData\Price\Mapper\PriceBaseDTOMapper;
use App\Form\MasterData\Price\PriceBaseCreateForm;
use App\Form\MasterData\Price\PriceBaseEditForm;
use App\Repository\PriceBaseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class PriceBaseProductController extends AbstractController
{
    #[\Symfony\Component\Routing\Annotation\Route('/price/base/create', name: 'price_base_create')]
    public function create(PriceBaseDTOMapper $mapper, EntityManagerInterface $entityManager,
        Request $request
    ): Response {
        $productAttributeDTO = new PriceBaseDTO();

        $form = $this->createForm(PriceBaseCreateForm::class, $productAttributeDTO);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $productAttribute = $mapper->mapDtoToEntity($form->getData());

            $entityManager->persist($productAttribute);
            $entityManager->flush();

            $this->addFlash(
                'success', "Product created successfully"
            );

            $id = $productAttribute->getId();
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
        PriceBaseRepository $productAttributeRepository, Request $request
    ): Response {
        $productAttributeDTO = new PriceBaseDTO();

        $priceBase = $productAttributeRepository->find($id);

        $form = $this->createForm(PriceBaseEditForm::class, $productAttributeDTO);

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