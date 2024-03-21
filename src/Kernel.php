<?php

namespace App;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    public function getCacheDir(): string
    {
        if($this->environment=="dev"){
            return $this->getDefaultCacheAndLogPath().'/cache'; //magic happens here

        }
        return dirname(__DIR__) . '/var/' . $this->environment . '/cache';
    }

    public function getLogDir(): string
    {
        if($this->environment=="dev"){
            return $this->getDefaultCacheAndLogPath().'/logs'; //and here
    }
        return dirname(__DIR__).'/var/'.$this->environment.'/logs';
    }

    private function getDefaultCacheAndLogPath() :string
    {
        return '/var/allcache/'.substr($this->getProjectDir(),strlen('/var/www/html'),strlen($this->getProjectDir()));
    }


}