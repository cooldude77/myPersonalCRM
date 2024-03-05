<?php
// src/Controller/PriceController.php
namespace App\Controller\Admin\Price;

// ...
use App\Entity\PriceBaseProduct;
use App\Form\Admin\Price\PriceBaseProductCreateForm;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PriceController extends AbstractController
{
    #[Route('/product/{id}/base/price', name: 'create_price')]
    public function createBasePriceForProduct($id, EntityManagerInterface $entityManager, ProductRepository $productRepository, Request $request): Response
    {
        $type = new PriceBaseProduct();
        $type->setProduct($productRepository->findOneBy(['id' => $id]));

        $form = $this->createForm(PriceBaseProductCreateForm::class, $type);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // perform some action...
            $entityManager->persist($form->getData());
            $entityManager->flush();

            return $this->redirectToRoute('admin/price/success_create.html.twig');
        }
        return $this->render('admin/price/base_product/create.html.twig', ['form' => $form]);
    }


}