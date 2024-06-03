<?php

namespace App\Controller\Admin\UI\Panel\Components;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class PanelHomeController extends AbstractController
{

    public function home(): Response
    {

        return $this->render('admin/ui/panel/section/home/home.html.twig');

    }
}