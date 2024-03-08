<?php

namespace App\Config\Admin;

use App\Config\System\FieldListInterface;

class ProductFieldList implements FieldListInterface
{


    /**
     * @return array
     */
    public function fieldsToShowOnListEntity()
    {
        return ['code', 'description'];
    }
}