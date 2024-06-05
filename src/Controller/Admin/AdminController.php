<?php

namespace App\Controller\Admin;

use App\Controller\Admin\UI\PanelMainController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AdminController extends AbstractController
{

    #[Route('/admin', name: 'admin_panel')]
    public function admin(Request $request): Response
    {

        $session = $request->getSession();
        $session->set(PanelMainController::CONTEXT_ROUTE_SESSION_KEY, 'admin_panel');

        return $this->forward(PanelMainController::class . '::main', ['request' => $request]);

    }

}