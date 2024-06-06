<?php

namespace App\Controller\Module\WebShop\External\Shop;

use App\Controller\Component\UI\Panel\Components\PanelContentController;
use App\Controller\Component\UI\Panel\Components\PanelHeaderController;
use App\Controller\Component\UI\Panel\Components\PanelSideBarController;
use App\Controller\Component\UI\PanelMainController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class ShopController extends AbstractController
{

    public function shop(Request $request, SessionInterface $session): Response
    {


        $session->set(PanelMainController::CONTEXT_ROUTE_SESSION_KEY, 'home');

        $session->set(
            PanelSideBarController::SIDE_BAR_CONTROLLER_CLASS_NAME, SideBarController::class
        );
        $session->set(
            PanelSideBarController::SIDE_BAR_CONTROLLER_CLASS_METHOD_NAME,
            'sideBar'
        );

        $session->set(
            PanelHeaderController::HEADER_CONTROLLER_CLASS_NAME, HeaderController::class
        );
        $session->set(
            PanelHeaderController::HEADER_CONTROLLER_CLASS_METHOD_NAME,
            'header'
        );

        $session->set(
            PanelContentController::CONTENT_CONTROLLER_CLASS_NAME, ProductListController::class
        );
        $session->set(
            PanelContentController::CONTENT_CONTROLLER_CLASS_METHOD_NAME,
            'list'
        );

        return $this->forward(PanelMainController::class . '::main', ['request' => $request]);

    }

}