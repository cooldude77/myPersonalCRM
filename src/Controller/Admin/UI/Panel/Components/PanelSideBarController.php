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
        $adminUrl = $router->generate('admin_panel');

        if ($customerFromUserFinder->getLoggedInCustomer() == null) {
            $role = 'ROLE_CUSTOMER';
        } else {
            $role = 'ROLE_EMPLOYEE';
        }

        $sideBar = $roleBasedSideBarList->getListBasedOnRole($role, $adminUrl);
        return $this->render(
            'admin/ui/panel/section/sidebar/sidebar.html.twig', ['sideBar' => $sideBar]
        );

    }
}