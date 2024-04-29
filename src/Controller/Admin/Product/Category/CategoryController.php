<?php
// src/Controller/LuckyController.php
namespace App\Controller\Admin\Product\Category;

use App\Form\Admin\Product\Category\CategoryCreateForm;
use App\Form\Admin\Product\Category\DTO\CategoryDTO;
use App\Form\Admin\Product\Category\Mapper\CategoryDTOMapper;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CategoryController extends
    AbstractController
{
    private EntityManagerInterface $entityManager;
    private CategoryDTOMapper $categoryDTOMapper;

    public function __construct(EntityManagerInterface $entityManager,
                                CategoryDTOMapper      $categoryDTOMapper)
    {
        $this->entityManager = $entityManager;
        $this->categoryDTOMapper = $categoryDTOMapper;
    }

    #[Route('/category/create', 'category_create')]
    public function create(Request $request): Response
    {
        $category = new CategoryDTO();
        $form = $this->createForm(CategoryCreateForm::class,
            $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // IF we do getData on form , it returns the description instead of id
            // so here we get full parent directly and then use it in the mapper
            $parent = $form->get('parent')->getData();
            $categoryEntity = $this->categoryDTOMapper->mapToEntity($form->getData(),
                $parent);

            // perform some action...
            $this->entityManager->persist($categoryEntity);
            $this->entityManager->flush();

            if ($request->get('_redirect_upon_success_url')) {
                $this->addFlash('success',
                    "Category created successfully");

                $id = $categoryEntity->getId();
                $success_url = $request->get('_redirect_upon_success_url') . "&id=$id";

                return $this->redirect($success_url);
            }
            return $this->render('/common/miscellaneous/success/create.html.twig',
                ['message' => 'Category successfully created']);
        }

        return $this->render('/admin/category/create.html.twig',
            ['form' => $form]);
    }


    #[\Symfony\Component\Routing\Annotation\Route('/category/edit/{id}', name: 'category_edit')]
    public function edit(EntityManagerInterface $entityManager,
                         CategoryRepository     $categoryRepository,
                         CategoryDTOMapper $categoryDTOMapper,
                         Request                $request,
                         int                    $id): Response
    {
        $category = $categoryRepository->find($id);


        if (!$category) {
            throw $this->createNotFoundException('No category found for id ' . $id);
        }
        $categoryDTO = $categoryDTOMapper->mapFromEntity($category);

        $form = $this->createForm(CategoryCreateForm::class,
            $categoryDTO);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // perform some action...
            $entityManager->persist($form->getData());
            $entityManager->flush();

            if ($request->get('_redirect_upon_success_url')) {
                $this->addFlash('success',
                    "Category created successfully");

                $id = $category->getId();
                $success_url = $request->get('_redirect_upon_success_url') . "&id=$id";

                return $this->redirect($success_url);
            }
            return $this->render('/common/miscellaneous/success/create.html.twig',
                ['message' => 'Category successfully updated']);
        }

        return $this->render('/admin/category/create.html.twig',
            ['form' => $form]);
    }

    #[Route('/category/display/{id}', name: 'category_display')]
    public function display(CategoryRepository $categoryRepository,
                            int                $id): Response
    {
        $category = $categoryRepository->find($id);
        if (!$category) {
            throw $this->createNotFoundException('No category found for id ' . $id);
        }

        $displayParams = ['title' => 'Category', 'editButtonLinkText' => 'Edit', 'fields' => [['label' => 'Name', 'propertyName' => 'name'], ['label' => 'Description', 'propertyName' => 'description'],]];

        return $this->render('admin/category/category_display.html.twig',
            ['entity' => $category, 'params' => $displayParams]);

    }

    #[Route('/category/list', name: 'category_list')]
    public function list(CategoryRepository $categoryRepository): Response
    {

        $listGrid = [
            'title' => 'Category',
            'columns' => [
                ['label' => 'Name', 'propertyName' => 'name', 'action' => 'display'],
                ['label' => 'Description', 'propertyName' => 'description'],
            ],
            'createButtonConfig' => [
                'function' => 'category',
                'anchorText' => 'Create Category'
            ]];

        $categories = $categoryRepository->findAll();
        return $this->render('admin/ui/panel/section/content/list/list.html.twig',
            ['entities' => $categories, 'listGrid' => $listGrid]);
    }
}