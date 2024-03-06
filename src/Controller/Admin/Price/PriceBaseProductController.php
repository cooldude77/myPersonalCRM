<?php
// src/Controller/PriceController.php
namespace App\Controller\Admin\Price;

// ...
use App\Entity\PriceBaseProduct;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

class PriceBaseProductController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return PriceBaseProduct::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('product');
        yield IntegerField::new('price');
        yield AssociationField::new('currency');

        //  yield AssociationField::new('productType');
    }
}