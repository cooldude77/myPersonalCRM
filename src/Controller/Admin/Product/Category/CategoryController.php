<?php
// src/Controller/LuckyController.php
namespace App\Controller\Admin\Product\Category;

use App\Entity\Category;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CategoryController extends AbstractCrudController
{
    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('code');
        yield TextField::new('description');
        yield AssociationField::new('parent');

    }

    public static function getEntityFqcn(): string
    {
        return Category::class;
    }
}