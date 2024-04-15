<?php

namespace App\Controller\Admin\UI\Panel\Components;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PanelHeaderController extends AbstractController
{
 public function header(): \Symfony\Component\HttpFoundation\Response
 {
     return $this->render('admin/ui/panel/header/header.html.twig');
 }

}