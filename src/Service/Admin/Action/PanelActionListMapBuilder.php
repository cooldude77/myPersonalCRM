<?php

namespace App\Service\Admin\Action;

use App\Service\Admin\Action\Exception\EmptyActionListMapException;

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
                    ],
                    'file' => [
                        'routes' => [
                            'create' => 'file_create',
                            'edit' => 'file_edit',
                            'display'=>'file_display',
                            'list'=>'file_list'
                        ]
                    ],
                    'category_file_image'=>[
                        'routes' => [
                            'create' => 'category_file_image_create',
                            'edit' => 'category_file_image_edit',
                            'display'=>'category_file_image_display',
                            'list'=>'category_file_image_list'
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
    public function getPanelActionListMap(): PanelActionListMap
    {
        if(empty($this->actionListMap))
            throw new EmptyActionListMapException();
        return $this->actionListMap;
    }
}