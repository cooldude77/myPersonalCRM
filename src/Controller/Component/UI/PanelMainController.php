<?php

namespace App\Controller\Component\UI;

use App\Controller\Component\UI\Panel\Components\PanelHeaderController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 *  The panels logic will flow through this controller
 *  The main panel will display header, content, sidebar, footer
 *  The content panel will contain the actual route called
 */
class PanelMainController extends AbstractController
{

    public const string CONTEXT_ROUTE_SESSION_KEY = 'context_route';

    /**
     * @param Request $request
     *
     * @return Response
     *
     * The twig template has panels for header,content, sidebar and footer
     */
    public function main(Request $request): Response
    {
        $headerResponse = $this->forward(
            PanelHeaderController::class . '::' . 'header',
            ['request' => $request]
        );

        if ($headerResponse instanceof RedirectResponse) {
            return $this->redirect($headerResponse->getTargetUrl());
        }

        return $this->render('admin/ui/panel/panel_main.html.twig', [
            'header' => $headerResponse->getContent(),
            'request' => $request]);
    }

}