<?php

namespace App\Controller\Component\UI\Panel\Components;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class PanelHeaderController extends AbstractController
{
    public const string HEADER_CONTROLLER_CLASS_NAME = 'HEADER_CONTROLLER_CLASS_NAME';
    public const string HEADER_CONTROLLER_CLASS_METHOD_NAME = 'HEADER_CONTROLLER_CLASS_METHOD_NAME';

    public function header(Request $request, SessionInterface $session): Response
    {
        return $this->forward(
            $session->get(self::HEADER_CONTROLLER_CLASS_NAME)
            . "::"
            . $session->get(self::HEADER_CONTROLLER_CLASS_METHOD_NAME),
            ['request' => $request]
        );
    }

}