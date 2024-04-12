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
                        'header_text' => 'Category',
                        'items' => [
                            [
                                'url' => $this->append($adminUrl,
                                    'category'),
                                'text' => 'Categories'
                            ]
                        ]
                    ],
                    [
                        'header_text' => 'Product',
                        'items' => [
                            [
                                'url' => $this->append($adminUrl,
                                    'product'),
                                'text' => 'Product List'
                            ]
                        ]
                    ],
                    [
                        'header_text' => 'Customer',
                        'items' => [
                            [
                                'url' => $this->append($adminUrl,
                                    'customer'),
                                'text' => 'Customer List'
                            ]
                        ]
                    ],
                    [
                        'header_text' => 'Prices',
                        'items' => [
                            [
                                'url' => $this->append($adminUrl,
                                    'base_price'),
                                'text' => 'Prices List'
                            ]
                        ]
                    ],
                    [
                        'header_text' => 'WebShop',
                        'items' => [
                            [
                                'url' => $this->append($adminUrl,
                                    '_target_route=web_shop'),
                                'text' => 'WebShop List'
                            ]
                        ]
                    ],
                    [
                        'header_text' => 'Users',
                        'items' =>[
                            [
                            'url' => $this->append($adminUrl,
                                '_target_route=user'),
                                'text' => 'Users List'
                            ]
                        ]
                    ]
               ]
            ]

        );
    }

    private function append(string $adminUrl,
                            string $function): string
    {
        return  $adminUrl . "?_function={$function}&_type=listing";
    }
}