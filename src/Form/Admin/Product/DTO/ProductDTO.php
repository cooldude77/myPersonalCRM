<?php

namespace App\Form\Admin\Product\DTO;

use Symfony\Component\Validator\Constraints as Assert;
class ProductDTO
{

    public ?string $name =null;

    public ?string $description =null;

     public ?int $id = -1;
     public bool $isActive = false;

     public ?string $category = null;
}