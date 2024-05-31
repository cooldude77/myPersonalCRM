<?php

namespace App\Tests\Fixtures;

use App\Tests\Utility\MySessionFactory;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\HttpFoundation\Session\Session;

trait SessionFactoryFixture
{

    private Session $session;

    public function createSession(KernelBrowser $kernelBrowser):void
    {

        /** @var MySessionFactory $factory */
        $factory = $kernelBrowser->getContainer()->get('session.factory');

        $this->session = $factory->createSession();

    }
}