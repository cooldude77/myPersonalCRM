<?php
// src/Controller/LuckyController.php
namespace App\Controller\Admin\Category;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoriesController extends AbstractController
{
    #[Route('/categories/create')]
    public function number(): Response
    {
        $number = random_int(0, 100);

        return $this->render('categories/create_category.html.twig', [
            'number' => $number,
        ]);
    }
}