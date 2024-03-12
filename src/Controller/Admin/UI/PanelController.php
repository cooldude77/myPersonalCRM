<?php

namespace App\Controller\Admin\UI;

use App\Service\Admin\SideBar\PanelSideBarListMapBuilder;
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

        $adminUrl = $router->generate('admin_panel');

        $session = $request->getSession();
        $session->set('context_route', 'admin_panel');

        $mapBuilder = new PanelActionListMapBuilder();
        $map = $mapBuilder->build();

        $sideBarBuilder = new PanelSideBarListMapBuilder();
        $sideBar = $sideBarBuilder->build($adminUrl)->getSideBarList();


        if ($request->get('type') !== null) {

            // Prepare to read from map
            $type = $request->get('type');
            $function = $request->get('function');
            $routeName = $map->getRouteFromFunctionAndAction($function, $type);

            // call controller
            $route = $router->getRouteCollection()->get($routeName);
            $controllerAction = $route->getDefault('_controller');
            $response = $this->forward($controllerAction, ['id' => $request->get('id')], $request->query->all());

            $content = $response->getContent();

            // decide what to do next
            switch ($request->get('type')) {
                case 'list':
                case 'display':
                    return $this->render('admin/ui/panel/panel.html.twig',
                        [
                            'content' => $content,
                            'sidebarMenu' => $sideBar,
                            'actionListMap' => $map
                        ]);

                case 'create':

                    if ($response->getStatusCode() == 401) {
                        $redirect_url = $request->get('redirect_upon_success_url');
                        return $this->redirect($redirect_url);
                    } else
                        return $this->render('admin/ui/panel/panel.html.twig',
                            [
                                'content' => $content,
                                'sidebarMenu' => $sideBar,
                                'actionListMap' => $map
                            ]);
            }

        }

        return $this->render('admin/ui/panel/panel.html.twig',
            [
                'content' => "This is home",
                'sidebarMenu' => $sideBar,
                'actionListMap' => $map]);
    }
}