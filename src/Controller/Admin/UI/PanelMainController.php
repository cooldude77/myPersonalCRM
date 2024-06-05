<?php

namespace App\Controller\Admin\UI;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PanelMainController extends AbstractController
{

    public const CONTEXT_ROUTE_SESSION_KEY = 'context_route';

    #[Route('/admin', name: 'admin_panel')]
    public function admin(Request $request): Response
    {

        $session = $request->getSession();
        if ($session->get('context_route') == null) {
            $session->set(self::CONTEXT_ROUTE_SESSION_KEY, 'admin_panel');
        }

        return $this->render('admin/ui/panel/panel_main.html.twig');
    }
}