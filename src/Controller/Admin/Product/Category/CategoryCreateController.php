<?php
// src/Controller/LuckyController.php
namespace App\Controller\Admin\Product\Category;

use App\Entity\Category;
use App\Form\Admin\Product\Category\CategoryCreateForm;
use App\Form\Admin\Product\Category\CategoryForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryCreateController extends AbstractController
{
    #[Route('/category/create', 'category_create')]
    public function create(EntityManagerInterface $entityManager, Request $request): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryCreateForm::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // perform some action...
            $entityManager->persist($form->getData());
            $entityManager->flush();

            return $this->redirectToRoute('task_success');
        }

        return $this->render('/admin/categories/create.html.twig', ['form' => $form]);
    }
}