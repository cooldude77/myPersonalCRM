<?php

namespace App\Controller\Admin\UI;

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