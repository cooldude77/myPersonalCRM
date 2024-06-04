<?php

namespace App\Controller\Security\Admin\Customer\Profile;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilePageController extends AbstractController
{

    public function profile(): Response
    {
        // todo
        return $this->render('security/user/profile/page/profile_page.html.twig');
    }



}