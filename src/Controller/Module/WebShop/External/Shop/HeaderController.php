<?php

namespace App\Controller\Module\WebShop\External\Shop;

use App\Form\Module\WebShop\External\Shop\HeaderSearchForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class HeaderController extends AbstractController
{

    public function header(): Response
    {

        $form = $this->createForm(HeaderSearchForm::class);

        return $this->render(
            'module/web_shop/external/shop/header.html.twig',
            ['form' => $form]
        );


    }

}