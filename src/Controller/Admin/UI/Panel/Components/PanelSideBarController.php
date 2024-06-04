<?php

namespace App\Controller\Admin\UI\Panel\Components;

use App\Service\Admin\SideBar\Role\RoleBasedSideBarList;
use App\Service\Module\WebShop\External\CheckOut\Address\CustomerFromUserFinder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\RouterInterface;

class PanelSideBarController extends AbstractController
{

    public function sideBar(RouterInterface $router, RoleBasedSideBarList $roleBasedSideBarList,
        CustomerFromUserFinder $customerFromUserFinder
    ) {

        if ($customerFromUserFinder->getLoggedInCustomer() == null) {

            $topUrl = $router->generate('user_profile_panel');
            $role = 'ROLE_CUSTOMER';
        } else {
            $topUrl = $router->generate('admin_panel');
            $role = 'ROLE_EMPLOYEE';
        }

        $sideBar = $roleBasedSideBarList->getListBasedOnRole($role, $topUrl);
        return $this->render(
            'admin/ui/panel/section/sidebar/sidebar.html.twig', ['sideBar' => $sideBar]
        );

    }
}