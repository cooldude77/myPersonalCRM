<?php

namespace App\Controller\Admin\UI;

use App\Service\Admin\Action\PanelActionListMapBuilder;
use App\Service\Admin\SideBar\PanelSideBarListMapBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\RouterInterface;

class PanelMainController extends AbstractController
{


    #[Route('/admin', name: 'admin_panel')]
    public function admin(
        Request         $request,
        RouterInterface $router): Response
    {

        return $this->render('admin/ui/panel/panel_main.html.twig',
            ['content' => "This is home"]);
    }
}