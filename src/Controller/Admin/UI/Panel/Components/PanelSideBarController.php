<?php

namespace App\Controller\Admin\UI\Panel\Components;

use App\Controller\Admin\UI\PanelMainController;
use App\Exception\Module\WebShop\External\CheckOut\Address\UserNotLoggedInException;
use App\Service\Admin\SideBar\Role\RoleBasedSideBarList;
use App\Service\Module\WebShop\External\CheckOut\Address\CustomerFromUserFinder;
use App\Service\Module\WebShop\External\CheckOut\Address\UserNotAssociatedWithACustomerException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class PanelSideBarController extends AbstractController
{

    public function sideBar(RoleBasedSideBarList $roleBasedSideBarList,
        CustomerFromUserFinder $customerFromUserFinder,
        SessionInterface $session
    ): Response {

        try {
            $customerFromUserFinder->getLoggedInCustomer();

            $role = 'ROLE_CUSTOMER';

        } catch (UserNotLoggedInException $e) {
            return new Response("Not Authorized", 403);
        } catch (UserNotAssociatedWithACustomerException $e) {
            $role = 'ROLE_EMPLOYEE';
        }

        $sideBar = $roleBasedSideBarList->getListBasedOnRole(
            $role, $session
            ->get(PanelMainController::CONTEXT_ROUTE_SESSION_KEY)
        );
        return $this->render(
            'admin/ui/panel/section/sidebar/sidebar.html.twig', ['sideBar' => $sideBar]
        );

    }
}