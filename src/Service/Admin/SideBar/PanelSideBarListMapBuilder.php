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
                                'text' => 'Categories',
                                'id'=>'sidebar-link-category-list'
                            ],
                        ]
                    ],[
                        'header_text' => 'Products',
                        'items' => [
                            [
                                'url' => $this->append($adminUrl,
                                    'product'),
                                'text' => 'Products',
                                'id'=>'sidebar-link-product-list'
                            ],
                            [
                                'url' => $this->append($adminUrl,
                                    'product_type'),
                                'text' => 'Product Types',
                                'id'=>'sidebar-link-product-type-list'
                            ],
                            [
                                'url' => $this->append($adminUrl,
                                    'product_attribute'),
                                'text' => 'Product Attributes',
                                'id'=>'sidebar-link-product-attribute-list'
                            ],
                        ]
                    ],
[
                        'header_text' => 'Customers',
                        'items' => [
                            [
                                'url' => $this->append($adminUrl,
                                    'customer'),
                                'text' => 'Customer List',
                                'id'=>'sidebar-link-customer-list'
                            ],
                        ]
                    ],
                    [
                        'header_text' => 'WebShop',
                        'items' => [
                            [
                                'url' => $this->append($adminUrl,
                                    'web_shop'),
                                'text' => 'Shops',
                                'id'=>'sidebar-link-web-shop-list'
                            ]
                        ]
                    ],
                    [
                        'header_text' => 'Users',
                        'items' =>[
                            [
                            'url' => $this->append($adminUrl,
                                'user'),
                                'text' => 'Users',
                            'id'=>'sidebar-link-user-list'
                            ]
                        ]
                    ],                    [
                        'header_text' => 'Web Shop',
                        'items' =>[
                            [
                            'url' => $this->append($adminUrl,
                                'web_shop'),
                                'text' => 'Web Shop',
                            'id'=>'sidebar-link-shop-list'
                            ]
                        ]
                    ],
                    [
                        'header_text' => 'Files',
                        'items' =>[
                            [
                            'url' => $this->append($adminUrl,
                                'file'),
                                'text' => 'files',
                            'id'=>'sidebar-link-file-list'
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