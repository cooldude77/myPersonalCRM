<?php

namespace App\Controller\Admin\UI\Panel\Components;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

class PanelContentController extends
    AbstractController
{

    public function content(RouterInterface $router,
                            Request         $request)
    {


        $routeName = $request->get('call');

        if ($routeName == null) return $this->render('admin/ui/panel/content/content.html.twig',
            ['content' => "This is home"]);


        // call controller
        $callRoute = $router->getRouteCollection()->get($routeName);

        $controllerAction = $callRoute->getDefault('_controller');
        $response = $this->forward($controllerAction,[],$request->query->all());

        $content = $response->getContent();

        return $this->render('admin/ui/panel/content/content.html.twig',
            ['content' => $content]);
    }


}