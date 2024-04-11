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
                                'url' => $this->append($adminUrl,'category_list'),
                                'text' => 'Categories'
                            ]
                        ]
                    ],
                    [
                        'header_text' => 'Product',
                        'items' => [
                            [
                                'url' => $this->append($adminUrl,'product_list'),
                                'text' => 'Product List'
                            ]
                        ]
                    ],
                    [
                        'header_text' => 'Customer',
                        'items' => [
                            [
                                'url' => $this->append($adminUrl,'customer_list'),
                                'text' => 'Customer List'
                            ]
                        ]
                    ],
                    [
                        'header_text' => 'Prices',
                        'items' => [
                            [
                                'url' => $this->append($adminUrl,'base_price_list'),
                                'text' => 'Prices List'
                            ]
                        ]
                    ],
                    [
                        'header_text' => 'WebShop',
                        'items' => [
                            [
                                'url' => $this->append($adminUrl,'call=web_shop_list'),
                                'text' => 'WebShop List'
                            ]
                        ]
                    ],
                    [
                        'header_text' => 'Users',
                        'items' =>[
                            [
                            'url' => $this->append($adminUrl,'call=user_list'),
                                'text' => 'Users List'
                            ]
                        ]
                    ]
               ]
            ]

        );
    }

    private function append(string $adminUrl,string $string): string
    {
      return  $adminUrl . "?call={$string}".'&redirectTo=admin_panel';
    }
}