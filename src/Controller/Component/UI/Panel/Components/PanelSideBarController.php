<?php

namespace App\Controller\Component\UI\Panel\Components;

use App\Service\Admin\SideBar\Role\RoleBasedSideBarList;
use App\Service\Module\WebShop\External\CheckOut\Address\CustomerFromUserFinder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class PanelSideBarController extends AbstractController
{
    public const string SIDE_BAR_CONTROLLER_CLASS_NAME = 'SIDE_BAR_CONTROLLER_CLASS_NAME';
    public const string SIDE_BAR_CONTROLLER_CLASS_METHOD_NAME = 'SIDE_BAR_CONTROLLER_CLASS_METHOD_NAME';

    public function sideBar(RoleBasedSideBarList $roleBasedSideBarList,
        CustomerFromUserFinder $customerFromUserFinder,
        SessionInterface $session,
        Request $request
    ): Response {

        /*   try {
               $customerFromUserFinder->getLoggedInCustomer();

               $role = 'ROLE_CUSTOMER';

           } catch (UserNotLoggedInException $e) {
               return new Response("Not Authorized", 403);
           } catch (UserNotAssociatedWithACustomerException $e) {
               $role = 'ROLE_EMPLOYEE';
           }

           $sideBar = $roleBasedSideBarList->getListBasedOnRole(
               $role,
               $this->generateUrl(
                   $session
                       ->get(PanelMainController::CONTEXT_ROUTE_SESSION_KEY)
               )
           );
          */

        $response = $this->forward(
            $session->get(self::SIDE_BAR_CONTROLLER_CLASS_NAME)
            . "::"
            . $session->get(self::SIDE_BAR_CONTROLLER_CLASS_METHOD_NAME),
            ['request' => $request]
        );

        // clear session variables after content has been retrieved
        $session->set(self::SIDE_BAR_CONTROLLER_CLASS_NAME, null);
        $session->set(self::SIDE_BAR_CONTROLLER_CLASS_METHOD_NAME, null);

        return $response;

    }
}