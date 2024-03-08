<?php

namespace App\Controller\Module\WebShop\Admin;

use App\Entity\WebShopHome;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class WebShopHomeController extends AbstractController
{
    public static function getEntityFqcn(): string
    {
        return WebShopHome::class;
    }
}