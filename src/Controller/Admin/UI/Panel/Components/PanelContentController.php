<?php

namespace App\Controller\Admin\UI\Panel\Components;

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


        $function = $request->get('_function');
        $t = $request->get('_type');

        // special case when not calling any function, goto home
        if ($function == null && $t == null) return $this->render('admin/ui/panel/content/content.html.twig',
            ['content' => "This is home"]);

        $routeName = $builder->build()->getPanelActionListMap()->getRoute($function,
            $t);

        // call controller
        $callRoute = $router->getRouteCollection()->get($routeName);

        $controllerAction = $callRoute->getDefault('_controller');
        $params = ['request' => $request];
        if (!empty($request->get('id'))) $params['id'] = $request->get('id');
        $response = $this->forward($controllerAction,
            $params,
            $request->query->all());

        $content = $response->getContent();

        return $this->render('admin/ui/panel/content/content.html.twig',
            ['content' => $content]);
    }


}