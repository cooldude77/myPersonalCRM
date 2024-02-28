<?php
// src/Controller/LuckyController.php
namespace App\Controller\Admin\Category;

use App\Entity\Category;
use App\Form\Admin\Category\CategoryForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoriesController extends AbstractController
{
    #[Route('/category/create', 'category_create')]
    public function create(): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryForm::class, $category);

        return $this->render('/admin/categories/create.html.twig', ['form' => $form]);
    }
}