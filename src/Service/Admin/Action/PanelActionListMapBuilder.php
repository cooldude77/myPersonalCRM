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
                    ]
                ]
            ]
        );
    }
}