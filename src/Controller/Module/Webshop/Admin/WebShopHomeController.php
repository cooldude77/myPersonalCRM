<?php

namespace App\Controller\Module\Webshop\Admin;

use App\Entity\WebshopHome;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class WebShopHomeController extends AbstractCrudController
{


    public static function getEntityFqcn(): string
    {
        return WebshopHome::class;
    }
}