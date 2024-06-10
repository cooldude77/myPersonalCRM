<?php

namespace App\Service\Component\UI\Panel;

use Symfony\Component\HttpFoundation\RequestStack;

class SessionAndMethodChecker
{


    public function __construct(private  readonly RequestStack $requestStack)
    {
    }

    public function checkSessionVariablesAndMethod(string $className,string $methodName):bool{

        return $this->requestStack->getSession()->get($className) != null
        && $this->requestStack->getSession()->get($methodName)
        && method_exists(
            $className,
            $methodName
        );
    }
}