<?php

namespace App\Controller\Admin\Employee;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SettingsController extends AbstractController
{


    #[Route('/system/settings', 'system_settings')]
    public function list(): Response
    {

        return new Response();

    }

}