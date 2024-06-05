<?php

namespace App\Controller\Admin\UI\Panel\Components;

use App\Exception\Module\WebShop\External\CheckOut\Address\UserNotLoggedInException;
use App\Service\Admin\SideBar\Role\RoleBasedSideBarList;
use App\Service\Module\WebShop\External\CheckOut\Address\CustomerFromUserFinder;
use App\Service\Module\WebShop\External\CheckOut\Address\UserNotAssociatedWithACustomerException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\Routing\RouterInterface;

class PanelSideBarController extends AbstractController
{

    public function sideBar(RouterInterface $router, RoleBasedSideBarList $roleBasedSideBarList,
        CustomerFromUserFinder $customerFromUserFinder
    ): Response {

        try {
            $customerFromUserFinder->getLoggedInCustomer();

            $topUrl = $router->generate('user_profile_panel');
            $role = 'ROLE_CUSTOMER';

        } catch (UserNotLoggedInException $e) {
            return new Response("Not Authorized",403);
        } catch (UserNotAssociatedWithACustomerException $e) {
            $topUrl = $router->generate('admin_panel');
            $role = 'ROLE_EMPLOYEE';
        }

        $sideBar = $roleBasedSideBarList->getListBasedOnRole($role, $topUrl);
        return $this->render(
            'admin/ui/panel/section/sidebar/sidebar.html.twig', ['sideBar' => $sideBar]
        );

    }
}