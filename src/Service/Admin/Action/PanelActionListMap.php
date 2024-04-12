<?php

namespace App\Service\Admin\Action;

use App\Service\Admin\Action\Exception\ActionNotFoundInMap;
use App\Service\Admin\Action\Exception\FunctionNotFoundInMap;

class PanelActionListMap
{
    private array $actionList;

    public function __construct(array $actionList)
    {

        $this->actionList = $actionList;
    }

    /**
     * @throws FunctionNotFoundInMap|ActionNotFoundInMap
     */
    public function getRoute(string $function, string $action): string
    {

        if(!empty( $this->getActions($function)['routes'][$action]))
            throw new ActionNotFoundInMap($function,$action);
        return $this->getActions($function)['routes'][$action];
    }

    /**
     * @throws FunctionNotFoundInMap
     */
    private function getActions(string $function): array
    {

        if(empty($this->actionList['functions'][$function]))
            throw new FunctionNotFoundInMap($function);
        else
            return $this->actionList['functions'][$function];
    }
}