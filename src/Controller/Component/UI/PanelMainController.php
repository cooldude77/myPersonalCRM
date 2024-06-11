<?php

namespace App\Controller\Component\UI;

use App\Controller\Component\UI\Panel\Components\PanelHeaderController;
use App\Exception\Component\UI\BaseTemplateNotFoundPanelMainException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Twig\Environment;

/**
 *  The panels logic will flow through this controller
 *  The main panel will display header, content, sidebar, footer
 *  The content panel will contain the actual route called
 */
class PanelMainController extends AbstractController
{

    public const string CONTEXT_ROUTE_SESSION_KEY = 'context_route';
    public const string BASE_TEMPLATE = 'BASE_TEMPLATE';

    /**
     * @param Request $request
     *
     * @return Response
     *
     * The twig template has panels for header,content, sidebar and footer
     * @throws BaseTemplateNotFoundPanelMainException
     */
    public function main(Request $request, Environment $environment): Response
    {


        $this->checkMandatoryParameters($request->getSession(), $environment);

        $headerResponse = $this->forward(
            PanelHeaderController::class . '::' . 'header',
            ['request' => $request]
        );

        if ($headerResponse instanceof RedirectResponse) {
            return $this->redirect($headerResponse->getTargetUrl());
        }


        $response = $this->render('admin/ui/panel/panel_main.html.twig', [
            'header' => $headerResponse->getContent(),
            'request' => $request]);

        if ($response instanceof RedirectResponse) {
            return $this->redirect($headerResponse->getTargetUrl());
        }

        $this->resetParameters($request->getSession());
        return $response;
    }

    /**
     * @param SessionInterface $session
     * @param Environment      $environment
     *
     * @return void
     * @throws BaseTemplateNotFoundPanelMainException
     */
    private function checkMandatoryParameters(SessionInterface $session, Environment $environment
    ): void {
        if ($session->get(self::BASE_TEMPLATE) != null) {
            if ($environment->getLoader()->exists($session->get(self::BASE_TEMPLATE))) {
                return;
            }
        }
        throw  new BaseTemplateNotFoundPanelMainException();

    }

    /**
     * @param SessionInterface $session
     *
     * @return void
     */
    private function resetParameters(SessionInterface $session)
    {
        $session->set(self::BASE_TEMPLATE, null);
    }

}