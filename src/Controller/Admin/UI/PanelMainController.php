<?php

namespace App\Controller\Admin\UI;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PanelMainController extends AbstractController
{

    public const CONTEXT_ROUTE_SESSION_KEY = 'context_route';

    public function main(Request $request): Response
    {
        return $this->render('admin/ui/panel/panel_main.html.twig',['request'=>$request]);
    }

}