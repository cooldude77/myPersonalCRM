<?php

namespace App\Controller\Admin\UI\Panel\Components;

use App\Service\Admin\SideBar\PanelSideBarListMapBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Router;
use Symfony\Component\Routing\RouterInterface;

class PanelSideBarController extends AbstractController
{

    public function sideBar(RouterInterface $router)
    {
        $adminUrl = $router->generate('admin_panel');

        $sideBarBuilder = new PanelSideBarListMapBuilder();
        $sideBar = $sideBarBuilder->build($adminUrl)->getSideBarList();

        return $this->render('admin/ui/sidebar/sidebar.html.twig',['sideBar'=>$sideBar]);

    }
}