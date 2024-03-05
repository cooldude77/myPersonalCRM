<?php

namespace App\Controller\Admin\UI;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PanelController extends AbstractController
{
    #[Route('/admin', name: 'admin_panel')]
    public function createProduct(EntityManagerInterface $entityManager, Request $request): Response
    {

        return $this->render('admin/ui/panel/panel.html.twig');
    }

}