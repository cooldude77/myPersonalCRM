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
                    'product_attribute' => [
                        'routes' => [
                            'create' => 'product_attribute_create',
                            'edit' => 'product_attribute_edit',
                            'display' => 'product_attribute_display',
                            'list' => 'product_attribute_list'
                        ]
                    ],
                    'product_type' => [
                        'routes' => [
                            'create' => 'product_type_create',
                            'edit' => 'product_type_edit',
                            'display' => 'product_type_display',
                            'list' => 'product_type_list'
                        ]
                    ],
                    'customer' => [
                        'routes' => [
                            'create' => 'customer_create',
                            'edit' => 'customer_edit',
                            'display' => 'customer_display',
                            'list' => 'customer_list'
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
                    ],
                    'web_shop'=>[
                        'routes' => [
                            'create' => 'web_shop_create',
                            'edit' => 'web_shop_edit',
                            'display'=>'web_shop_display',
                            'list'=>'web_shop_list'
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