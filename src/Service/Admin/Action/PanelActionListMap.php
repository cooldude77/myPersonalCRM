<?php

namespace App\Service\Admin\Action;

class PanelActionListMap
{
    private array $actionList;

    public function __construct(array $actionList)
    {

        $this->actionList = $actionList;
    }

    public function getRouteFromFunctionAndAction(string $function, string $action): string
    {

        $routes = $this->getActionsFromFunction($function)['routes'];
        return $routes[$action];
    }

    public function getActionsFromFunction(string $function): array
    {

        return $this->actionList['functions'][$function];
    }
}