<?php

namespace App\Config\Admin;

use App\Config\System\FieldListInterface;

class CategoryFieldList implements FieldListInterface
{


    /**
     * @return array
     */
    public function fieldsToShowOnListEntity()
    {
        return ['code', 'description'];
    }
}