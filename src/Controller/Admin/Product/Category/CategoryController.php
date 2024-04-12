<?php
// src/Controller/LuckyController.php
namespace App\Controller\Admin\Product\Category;

use App\Config\Admin\CategoryFieldList;
use App\Entity\Category;
use App\Form\Admin\Product\Category\CategoryCreateForm;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CategoryController extends AbstractController
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

            return $this->render('/common/miscellaneous/success/create.html.twig', ['message' => 'Category successfully created']);
        }

        return $this->render('/admin/category/create.html.twig', ['form' => $form]);
    }


    #[\Symfony\Component\Routing\Annotation\Route('/category/edit/{id}', name: 'category_edit')]
    public function update(CategoryRepository $categoryRepository, int $id): Response
    {
        $category = $categoryRepository->find($id);


        if (!$category) {
            throw $this->createNotFoundException(
                'No category found for id ' . $id
            );
        }

        $category->setDescription('New .... ');
        $categoryRepository->getEntityManager()->flush($category);


        // or render a template
        // in the template, print things with {{ category.name }}
        return $this->render('category/show.html.twig', ['category' => $category]);
    }

    #[Route('/category/display/{id}', name: 'category_display')]
    public function display(CategoryRepository $categoryRepository, int $id): Response
    {
        $category = $categoryRepository->find($id);
        if (!$category) {
            throw $this->createNotFoundException(
                'No category found for id ' . $id
            );
        }

        return $this->render('admin/category/display.html.twig', ['category' => $category]);

    }

    #[Route('/category/list', name: 'category_list')]
    public function list(CategoryRepository $categoryRepository): Response
    {
        $displayUrl = '';
        $listGrid=
            [
              'columns'=>[
                [
                    'label'=>'Name',
                  'propertyName'=>'name'
                ],
                  [
                      'label'=>'Description',
                     'propertyName'=>'description'
                 ],

              ],
                'create_button'=>[
                    'targetRoute'=>'category_create',
                    'redirectRoute'=>'admin_panel',
                    'call_in_redirect_route'=>'category_create'
                ]
            ];


        $categories = $categoryRepository->findAll();
        return $this->render('admin/common/list/list.html.twig', [
            'entities' => $categories,
            'listGrid'=> $listGrid]);
    }
}