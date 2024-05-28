<?php

namespace App\Controller\Module\WebShop\External\CheckOut\Address;

use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\Routing\RouterInterface;

class ControllerActionFinder
{

    /**
     * @param RouterInterface $router
     *
     * @return mixed
     */
    public function getControllerAction(RouterInterface $router): mixed
    {
// call controller
        $callRoute = $router->getRouteCollection()->get('customer_address_create');

        if ($callRoute == null) {
            throw  new RouteNotFoundException('customer_address_create');
        }

        $controllerAction = $callRoute->getDefault('_controller');
        return $controllerAction;
    }
}