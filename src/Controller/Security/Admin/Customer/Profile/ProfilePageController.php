<?php

namespace App\Controller\Security\Admin\Customer\Profile;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProfilePageController extends AbstractController
{


    #[Route('/user/profile', name: 'user_profile')]
    public function profile(): Response
    {
        // todo
        return $this->render('security/admin/user/profile/page/profile_page.html.twig');
    }


}