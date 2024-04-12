<?php

namespace App\Controller\Admin\UI\Panel\Components;

use App\Service\Admin\Action\PanelActionListMap;
use App\Service\Admin\Action\PanelActionListMapBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

class PanelContentController extends
    AbstractController
{

    public function content(RouterInterface           $router,
                            Request                   $request,
                            PanelActionListMapBuilder $builder): Response
    {


        $function = $request->get('function');
        $type = $request->get('type');

        // special case when not calling any function, goto home
        if($function == null && $type == null)
            return $this->render('admin/ui/panel/content/content.html.twig',
                ['content' => "This is home"]);

        $routeName = $builder->build()->getPanelActionListMap()->getRoute($function,$type);

        // call controller
        $callRoute = $router->getRouteCollection()->get($routeName);

        $controllerAction = $callRoute->getDefault('_controller');
        $response = $this->forward($controllerAction,
            [],
            $request->query->all());

        $content = $response->getContent();

        return $this->render('admin/ui/panel/content/content.html.twig',
            ['content' => $content]);
    }


}