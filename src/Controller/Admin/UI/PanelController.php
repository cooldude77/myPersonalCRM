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

        $session = $request->getSession();
        $session->set('context_route', 'admin_panel');

        $actions = [

            'functions' => [
                'name' => 'Product',
                'routes' => [
                    ['create', 'product_create'],
                    ['edit', 'product_edit'],
                    ['display', 'product_display'],
                    ['list', 'product_list']
                ]
            ]
        ];

        $sideBar =
            [
                'sections' => [
                    [
                        'header_text' => 'Product',
                        'items' => [
                            [
                                'url' => $adminUrl . '?load_next=product_list&type=list&context_route=admin_panel',
                                'text' => 'Product List'
                            ]
                        ]
                    ],
                    [
                        'header_text' => 'Customer',
                        'items' => [
                            [
                                'url' => $adminUrl . '?load_next=customer_list&type=list&context_route=admin_panel',
                                'text' => 'Customer List'
                            ]
                        ]
                    ],
                    [
                        'header_text' => 'Prices',
                        'items' => [
                            [
                                'url' => $adminUrl . '?load_next=web_shop_list&type=list&context_route=admin_panel',
                                'text' => 'Prices List'
                            ]
                        ]
                    ],
                    [
                        'header_text' => 'WebShop',
                        'items' => [
                            [
                                'url' => $adminUrl . '?load_next=web_shop_list&type=list&context_route=admin_panel',
                                'text' => 'WebShop List'
                            ]
                        ]
                    ], [
                        'header_text' => 'Users',
                        'items' => [
                            [
                                'url' => $adminUrl . '?load_next=web_shop_list&type=list&context_route=admin_panel',
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

            $response = $this->forward($controllerAction, ['id' => $request->get('id')], $request->query->all());
            $content = $response->getContent();

            switch ($request->get('type')) {
                case 'list':
                case 'display':
                    return $this->render('admin/ui/panel/panel.html.twig',
                        ['content' => $content, 'sidebarMenu' => $sideBar]);

                case 'create':

                    if ($response->getStatusCode() == 401) {
                        $redirect_url = $request->get('redirect_upon_success_url');
                        return $this->redirect($redirect_url);
                    } else
                        return $this->render('admin/ui/panel/panel.html.twig',
                            ['content' => $content,
                                'sidebarMenu' => $sideBar,
                                'actions' => $actions]);
            }

        }

        return $this->render('admin/ui/panel/panel.html.twig',
            ['content' => "This is home",
                'sidebarMenu' => $sideBar,
                'actions' => $actions]);
    }
}