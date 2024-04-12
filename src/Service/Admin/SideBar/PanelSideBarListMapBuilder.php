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
                                'url' => $this->append($adminUrl,'category','list'),
                                'text' => 'Categories'
                            ]
                        ]
                    ],
                    [
                        'header_text' => 'Product',
                        'items' => [
                            [
                                'url' => $this->append($adminUrl,'product','list'),
                                'text' => 'Product List'
                            ]
                        ]
                    ],
                    [
                        'header_text' => 'Customer',
                        'items' => [
                            [
                                'url' => $this->append($adminUrl,'customer','list'),
                                'text' => 'Customer List'
                            ]
                        ]
                    ],
                    [
                        'header_text' => 'Prices',
                        'items' => [
                            [
                                'url' => $this->append($adminUrl,'base_price','list'),
                                'text' => 'Prices List'
                            ]
                        ]
                    ],
                    [
                        'header_text' => 'WebShop',
                        'items' => [
                            [
                                'url' => $this->append($adminUrl,'_target_route=web_shop','list'),
                                'text' => 'WebShop List'
                            ]
                        ]
                    ],
                    [
                        'header_text' => 'Users',
                        'items' =>[
                            [
                            'url' => $this->append($adminUrl,'_target_route=user','list'),
                                'text' => 'Users List'
                            ]
                        ]
                    ]
               ]
            ]

        );
    }

    private function append(string $adminUrl,string $function,string $typeOfOperation): string
    {
      return  $adminUrl . "?function={$function}&type={$typeOfOperation}";
    }
}