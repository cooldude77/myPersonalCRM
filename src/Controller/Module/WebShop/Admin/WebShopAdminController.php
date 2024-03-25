<?php

namespace App\Controller\Module\WebShop\Admin;

use App\Form\Module\WebShop\Admin\DTO\WebShopDTO;
use App\Form\Module\WebShop\Admin\Mapper\WebShopDTOMapper;
use App\Form\Module\WebShop\Admin\WebShopCreateForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class WebShopAdminController extends AbstractController
{
    #[Route('/web-shop/create', name: 'module_web_shop_create')]
    public function createWebShop(EntityManagerInterface $entityManager, WebShopDTOMapper $webShopDTOMapper,
                                  Request $request)
    {

        $webShopDTO = new WebShopDTO();

        $form = $this->createForm(WebShopCreateForm::class, $webShopDTO);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $webShopEntity = $webShopDTOMapper->map($form->getData());

            // perform some action...
            $entityManager->persist($webShopEntity);
            $entityManager->flush();

            $response = $this->render('module/web_shop/admin/web_shop/success.html.twig');
            $response->setStatusCode(401);

            return $response;
        }
        return $this->render('module/web_shop/admin/web_shop/create.html.twig', ['form' => $form]);


    }
}