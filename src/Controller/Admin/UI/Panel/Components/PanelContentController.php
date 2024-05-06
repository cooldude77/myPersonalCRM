<?php

namespace App\Controller\Admin\UI\Panel\Components;

use App\Service\Admin\Action\Exception\EmptyActionListMapException;
use App\Service\Admin\Action\Exception\FunctionNotFoundInMap;
use App\Service\Admin\Action\Exception\TypeNotFoundInMap;
use App\Service\Admin\Action\PanelActionListMapBuilder;
use PHPUnit\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\Routing\RouterInterface;

class PanelContentController extends AbstractController
{

    /**
     * @throws FunctionNotFoundInMap
     * @throws TypeNotFoundInMap
     * @throws EmptyActionListMapException
     */
    public function content(RouterInterface $router, Request $request,
        PanelActionListMapBuilder $builder
    ): Response {


        $function = $request->get('_function');
        $type = $request->get('_type');

        // special case when not calling any function, goto home
        if ($function == null && $type == null) {
            return $this->render(
                'admin/ui/panel/section/content/content.html.twig', ['content' => "This is home"]
            );
        }

        $routeName = $builder->build()->getPanelActionListMap()->getRoute(
            $function, $type
        );

        // call controller
        $callRoute = $router->getRouteCollection()->get($routeName);

        if ($callRoute == null) {
            throw  new RouteNotFoundException($routeName);
        }

        $controllerAction = $callRoute->getDefault('_controller');
        $params = ['request' => $request];
        if (!empty($request->get('id'))) {
            $params['id'] = $request->get('id');
        }
        $response = $this->forward(
            $controllerAction, $params, $request->query->all()
        );

        $content = $response->getContent();

        try {
            $unserialized = unserialize($content);

            if (!empty($unserialized['id'])) {
                $success_url = $request->get('_redirect_upon_success_url') . "&id="
                    . $unserialized['id'];
                return $this->redirect($success_url);
            }
        } catch (Exception $e){

        }
        return $this->render(
            'admin/ui/panel/section/content/content.html.twig', ['content' => $content]
        );
    }


}