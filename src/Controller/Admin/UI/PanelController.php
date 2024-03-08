<?php

namespace App\Controller\Admin\UI;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;

class PanelController extends AbstractController
{
    #[Route('/admin', name: 'admin_panel')]
    public function admin(
        Request         $request,
        RouterInterface $router): Response
    {

        if ($request->get('load_next') !== null) {
            $routeName = $request->get('load_next');
            $route = $router->getRouteCollection()->get($routeName);
            $controllerAction = $route->getDefault('_controller');

            $content = $this->forward($controllerAction)->getContent();
            return $this->render('admin/ui/panel/panel.html.twig', ['content' => $content]);
        }
        return $this->render('admin/ui/panel/panel.html.twig', ['content' => null]);
    }
}