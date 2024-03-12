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
                                'url' => $adminUrl . '?function=product&type=list',
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

            ]

        );
    }
}