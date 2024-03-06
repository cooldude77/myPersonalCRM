<?php

namespace App\Controller\Modules\Webshop\Admin;

use App\Entity\WebshopHomeSection;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class WebShopHomeSectionController extends AbstractCrudController
{


    public static function getEntityFqcn(): string
    {
        return WebshopHomeSection::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name');
        yield TextField::new('header');
        yield IntegerField::new('sectionOrder');
        yield AssociationField::new('webshopHome');

        //  yield AssociationField::new('productType');
    }
}