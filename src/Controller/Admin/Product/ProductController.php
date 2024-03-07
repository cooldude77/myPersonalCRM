<?php
// src/Controller/ProductController.php
namespace App\Controller\Admin\Product;

// ...
use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProductController extends AbstractCrudController
{

    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('code');
        yield TextField::new('description');
        yield AssociationField::new('category');
        yield AssociationField::new('type');

        //  yield AssociationField::new('productType');
    }
}