<?php

namespace App\Service\Admin\SideBar;

class PanelSideBarListMapBuilder
{

    public function build(string $adminUrl)
    {
        return new PanelSideBarListMap(

            [
                'sections' => [
                    [
                        'header_text' => 'Product',
                        'items' => [
                            [
                                'url' => $adminUrl . '?function=product&type=list&context_route=admin_panel',
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

            ]

        );
    }
}