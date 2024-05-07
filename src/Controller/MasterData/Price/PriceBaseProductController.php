<?php
// src/Controller/PriceController.php
namespace App\Controller\MasterData\Price;

// ...
use App\Form\MasterData\Price\DTO\PriceBaseProductDTO;
use App\Form\MasterData\Price\Mapper\PriceBaseProductDTOMapper;
use App\Form\MasterData\Price\PriceBaseProductCreateForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class PriceBaseProductController extends AbstractController
{ #[Route('/price/product/{id}/create', name: 'price_base_create')]
public function createProduct(EntityManagerInterface $entityManager,
                              PriceBaseProductDTOMapper $baseProductDTOMapper,
                              Request $request): Response
{
    $type = new PriceBaseProductDTO();

    $form = $this->createForm(PriceBaseProductCreateForm::class, $type);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {

        $price =$baseProductDTOMapper->map($form->getData());
        // perform some action...
        $entityManager->persist($price);
        $entityManager->flush();

        $response = $this->render('master_data/product/success.html.twig');
        $response->setStatusCode(401);

        return $response;
    }
    return $this->render('master_data/product/create.html.twig', ['form' => $form]);
}

}