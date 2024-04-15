<?php

namespace App\Controller\Admin\UI\Panel\Components;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PanelHomeController extends AbstractController
{

    public function home(): \Symfony\Component\HttpFoundation\Response
    {

        return $this->render('admin/ui/panel/home/home.html.twig');

    }
}