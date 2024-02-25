<?php
// src/Controller/LuckyController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
class CategoriesCreateController extends AbstractController
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