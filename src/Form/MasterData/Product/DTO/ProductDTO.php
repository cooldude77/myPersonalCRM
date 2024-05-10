<?php

namespace App\Form\MasterData\Product\DTO;

class ProductDTO
{

    public ?string $name =null;

    public ?string $description =null;

     public ?int $id = -1;
     public bool $isActive = false;

     public ?string $category = null;
}