<?php

namespace App\Controller\Security\Admin\Customer\Profile;

use App\Controller\Admin\UI\Panel\Components\PanelHomeController;
use App\Controller\Admin\UI\PanelMainController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MyProfilePageController extends AbstractController
{


    #[Route('/my/profile', name: 'my_profile_panel')]
    public function profile(Request $request): Response
    {
        $session = $request->getSession();
        $session->set(PanelMainController::CONTEXT_ROUTE_SESSION_KEY, 'my_profile_panel');
        return $this->forward(PanelMainController::class . '::admin', ['request' => $request]);
    }

    #[Route('/my/addresses', name: 'my_address')]
    public function addresses(Request $request): Response
    {

    }

    #[Route('/my/orders', name: 'my_orders')]
    public function orders(Request $request): Response
    {
    }

    #[Route('/my/personal-data', name: 'my_personal_data')]
    public function personal(Request $request): Response
    {
    }


}