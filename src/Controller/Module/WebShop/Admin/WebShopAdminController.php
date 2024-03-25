<?php

namespace App\Controller\Module\WebShop\Admin;

use App\Entity\Product;
use App\Entity\WebShop;
use App\Form\Admin\Product\ProductCreateForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class WebShopAdminController extends AbstractController
{
    #[Route('/web-shop/create', name: 'module_web_shop_create')]
    public function createWebShop(EntityManagerInterface $entityManager, Request $request)
    {

        $type = new WebShop();

        $form = $this->createForm(ProductCreateForm::class, $type);

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