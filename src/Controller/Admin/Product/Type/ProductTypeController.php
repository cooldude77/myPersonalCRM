<?php
// src/Controller/ProductController.php
namespace App\Controller\Admin\Product\Type;

// ...
use App\Entity\ProductType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ProductTypeController extends AbstractCrudController
{


    public static function getEntityFqcn(): string
    {
        return ProductType::class;
    }
}