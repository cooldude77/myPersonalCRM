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
                        'header_text' => 'Categories',
                        'items' => [
                            [
                                'url' => $this->append($adminUrl,
                                    'category'),
                                'text' => 'Categories'
                            ],
                        ]
                    ],[
                        'header_text' => 'Products',
                        'items' => [
                            [
                                'url' => $this->append($adminUrl,
                                    'product'),
                                'text' => 'Products'
                            ],
                            [
                                'url' => $this->append($adminUrl,
                                    'product_type'),
                                'text' => 'Product Types'
                            ],
                            [
                                'url' => $this->append($adminUrl,
                                    'product_attribute'),
                                'text' => 'Product Attributes'
                            ],
                        ]
                    ],
[
                        'header_text' => 'Customers',
                        'items' => [
                            [
                                'url' => $this->append($adminUrl,
                                    'customer'),
                                'text' => 'Customer List'
                            ],
                        ]
                    ],
                    [
                        'header_text' => 'WebShop',
                        'items' => [
                            [
                                'url' => $this->append($adminUrl,
                                    'web_shop'),
                                'text' => 'Shops'
                            ]
                        ]
                    ],
                    [
                        'header_text' => 'Users',
                        'items' =>[
                            [
                            'url' => $this->append($adminUrl,
                                'user'),
                                'text' => 'Users'
                            ]
                        ]
                    ],
                    [
                        'header_text' => 'Files',
                        'items' =>[
                            [
                            'url' => $this->append($adminUrl,
                                'file'),
                                'text' => 'files'
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
        return  $adminUrl . "?_function={$function}&_type=list";
    }
}