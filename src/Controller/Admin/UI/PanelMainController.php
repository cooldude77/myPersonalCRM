<?php

namespace App\Controller\Admin\UI;

use App\Service\Admin\Action\Exception\PanelActionListMapBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PanelMainController extends AbstractController
{


    #[Route('/admin', name: 'admin_panel')]
    public function admin(Request $request): Response
    {

        $session = $request->getSession();
        $session->set('context_route', 'admin_panel');
        return $this->render('admin/ui/panel/panel_main.html.twig');
    }
}