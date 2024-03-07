<?php

namespace App\Controller\Module\WebShop\Admin;

use App\Entity\WebShopHomeSection;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class WebShopHomeSectionController extends AbstractCrudController
{


    public static function getEntityFqcn(): string
    {
        return WebShopHomeSection::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name');
        yield TextField::new('header');
        yield IntegerField::new('sectionOrder');
        yield AssociationField::new('webShopHome');

        //  yield AssociationField::new('productType');
    }
}