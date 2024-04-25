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
                        'header_text' => 'Master Data',
                        'items' => [
                            [
                                'url' => $this->append($adminUrl,
                                    'category'),
                                'text' => 'Categories'
                            ],
                            [
                                'url' => $this->append($adminUrl,
                                    'product'),
                                'text' => 'Product List'
                            ],
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
                                'text' => 'Users List'
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