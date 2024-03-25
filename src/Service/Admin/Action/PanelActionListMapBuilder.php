<?php

namespace App\Service\Admin\Action;

class PanelActionListMapBuilder
{

    public function build()
    {
        return new PanelActionListMap(
            [
                'functions' => [
                    'product' => [
                        'routes' => [
                            'create' => 'product_create',
                            'edit' => 'product_edit',
                            'display' => 'product_display',
                            'list' => 'product_list'
                        ]
                    ],
                    'category' => [
                        'routes' => [
                            'create' => 'category_create',
                            'edit' => 'category_edit',
                            'display' => 'category_display',
                            'list' => 'category_list'
                        ]
                    ] ,
                    'web-shop' => [
                        'routes' => [
                            'create' => 'web_shop_create',
                            'edit' => 'web_shop_edit'
                        ]
                    ]
                ]
            ]
        );
    }
}