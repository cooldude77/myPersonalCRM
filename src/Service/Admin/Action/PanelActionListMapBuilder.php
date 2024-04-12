<?php

namespace App\Service\Admin\Action;

/**
 * @method getPanelActionListMap()
 */
class PanelActionListMapBuilder
{

    private PanelActionListMap $actionListMap;
    /**
     * function - product/customer / webshop etc
     * route -> route names related to processes of a function
     */
    public function build() : PanelActionListMapBuilder
    {
        $this->actionListMap = new PanelActionListMap(
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
        return $this;
    }

    /**
     * @return PanelActionListMap
     */
    public function getActionListMap(): PanelActionListMap
    {
        return $this->actionListMap;
    }
}