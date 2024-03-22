<?php
// src/Controller/PriceController.php
namespace App\Controller\Admin\Price;

// ...
use App\Entity\PriceBaseProduct;
use App\Form\Admin\Price\DTO\PriceBaseProductDTO;
use App\Form\Admin\Price\PriceBaseProductCreateForm;
use Doctrine\ORM\EntityManagerInterface;
use http\Env\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;


class PriceBaseProductController extends AbstractController
{ #[Route('/price/product/{id}/create', name: 'price_base_create')]
public function createProduct(EntityManagerInterface $entityManager, Request $request): Response
{
    $type = new PriceBaseProductDTO();

    $form = $this->createForm(PriceBaseProductCreateForm::class, $type);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {

        // perform some action...
        $entityManager->persist($form->getData());
        $entityManager->flush();

        $response = $this->render('admin/product/success.html.twig');
        $response->setStatusCode(401);

        return $response;
    }
    return $this->render('admin/product/create.html.twig', ['form' => $form]);
}

}