<?php

namespace App\Controller\Module\WebShop\Admin;

use App\Entity\WebShopHome;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class WebShopHomeController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return WebShopHome::class;
    }
}