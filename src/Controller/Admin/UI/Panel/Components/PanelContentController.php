<?php

namespace App\Controller\Admin\UI\Panel\Components;

use App\Service\Admin\Action\PanelActionListMapBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

class PanelContentController extends AbstractController
{

    public function content(RouterInterface $router,Request $request)
    {
        $session = $request->getSession();
        $session->set('context_route', 'admin_panel');

        $mapBuilder = new PanelActionListMapBuilder();
        $map = $mapBuilder->build();

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
                    return $this->render('admin/ui/panel/content/content.html.twig',
                        [
                            'content' => $content,
                            'actionListMap' => $map
                        ]);

                case 'create':

                    if ($response->getStatusCode() == 401) {
                        $redirect_url = $request->get('redirect_upon_success_url');
                        return $this->redirect($redirect_url);
                    } else
                        return $this->render('admin/ui/panel/content/content.html.twig',
                            [
                                'content' => $content
                            ]);
            }

        }
        return $this->render('admin/ui/panel/content/content.html.twig',  ['content' => "This is home"]);
    }

}