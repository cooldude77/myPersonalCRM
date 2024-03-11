<?php

namespace App\Controller\Admin\UI;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;

class PanelController extends AbstractController
{
    #[Route('/admin', name: 'admin_panel')]
    public function admin(
        Request         $request,
        RouterInterface $router): Response
    {

        $adminUrl = $router->generate('admin_panel');
        $sideBar =
            [
                'sections' => [
                    [
                        'header_text' => 'Product',
                        'items' => [
                            [
                                'url' => $adminUrl . '?load_next=product_list&type=list',
                                'text' => 'Product List'
                            ]
                        ]
                    ],
                    [
                        'header_text' => 'Customer',
                        'items' => [
                            [
                                'url' => $adminUrl . '?load_next=customer_list&type=list',
                                'text' => 'Customer List'
                            ]
                        ]
                    ],
                    [
                        'header_text' => 'Prices',
                        'items' => [
                            [
                                'url' => $adminUrl . '?load_next=web_shop_list&type=list',
                                'text' => 'Prices List'
                            ]
                        ]
                    ],
                    [
                        'header_text' => 'WebShop',
                        'items' => [
                            [
                                'url' => $adminUrl . '?load_next=web_shop_list&type=list',
                                'text' => 'WebShop List'
                            ]
                        ]
                    ], [
                        'header_text' => 'Users',
                        'items' => [
                            [
                                'url' => $adminUrl . '?load_next=web_shop_list&type=list',
                                'text' => 'Users List'
                            ]
                        ]
                    ],


                ],

            ];


        if ($request->get('load_next') !== null) {
            $routeName = $request->get('load_next');
            $route = $router->getRouteCollection()->get($routeName);
            $controllerAction = $route->getDefault('_controller');
            $content = $this->forward($controllerAction)->getContent();

            return $this->render('admin/ui/panel/panel.html.twig', ['content' => $content, 'sidebarMenu' => $sideBar]);
        }
        return $this->render('admin/ui/panel/panel.html.twig', ['content' => "This is home", 'sidebarMenu' => $sideBar]);
    }
}