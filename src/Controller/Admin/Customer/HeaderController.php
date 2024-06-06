<?php

namespace App\Controller\Admin\Customer;

use App\Service\Admin\SideBar\Role\RoleBasedSideBarList;
use App\Service\Module\WebShop\External\CheckOut\Address\CustomerFromUserFinder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class HeaderController extends AbstractController
{

    public function header() :Response {

        // for now common header
        return $this->render('admin/ui/panel/header/header.html.twig');


    }
}