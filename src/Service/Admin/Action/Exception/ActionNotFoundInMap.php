<?php

namespace App\Service\Admin\Action\Exception;

class ActionNotFoundInMap extends \Exception
{

    /**
     * @param string $function
     * @param string $action
     */
    public function __construct(string $function,
                                string $action)
    {
        parent::__construct("Action {$action} not found for {$function}");
    }
}