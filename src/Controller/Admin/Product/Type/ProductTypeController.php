<?php
// src/Controller/ProductController.php
namespace App\Controller\Admin\Product\Type;

// ...
use App\Form\Admin\Product\Type\DTO\ProductTypeDTO;
use App\Form\Admin\Product\Type\ProductTypeCreateForm;
use App\Form\Admin\Product\Type\ProductTypeUpdateForm;
use App\Repository\ProductTypeRepository;
use App\Service\Product\Type\ProductTypeDTOMapper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProductTypeController extends AbstractController
{
    #[Route('/product/type/create', name: 'product_type_create')]
    public function create(ProductTypeDTOMapper $mapper, EntityManagerInterface $entityManager,
        Request $request
    ): Response {
        $productTypeDTO = new ProductTypeDTO();

        $form = $this->createForm(ProductTypeCreateForm::class, $productTypeDTO);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $productType = $mapper->mapDtoToEntityForCreate($form->getData());

            $entityManager->persist($productType);
            $entityManager->flush();

            if ($request->get('_redirect_upon_success_url')) {
                $this->addFlash(
                    'success', "Product created successfully"
                );

                $id = $productType->getId();
                $success_url = $request->get('_redirect_upon_success_url') . "&id=$id";

                return $this->redirect($success_url);
            }
            return $this->render(
                '/common/miscellaneous/success/create.html.twig',
                ['message' => 'Product successfully created']
            );
        }

        return $this->render(
            '/admin/ui/panel/section/content/create/create.html.twig', ['form' => $form]
        );

    }


  #[Route('/product/type/{id}/edit', name: 'product_type_edit')]
    public function edit(
        int $id,
        ProductTypeDTOMapper $mapper, EntityManagerInterface $entityManager,
        ProductTypeRepository $productTypeRepository,
        Request $request
    ): Response {
        $productTypeDTO = new ProductTypeDTO();

        $productTypeEntity =  $productTypeRepository->find($id);

        $form = $this->createForm(ProductTypeUpdateForm::class, $productTypeDTO);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $productTypeEntity = $mapper->mapDtoToEntityForUpdate($form->getData(),$productTypeEntity);

            $entityManager->persist($productTypeEntity);
            $entityManager->flush();

            if ($request->get('_redirect_upon_success_url')) {
                $this->addFlash(
                    'success', "Product created successfully"
                );

                $id = $productTypeEntity->getId();
                $success_url = $request->get('_redirect_upon_success_url') . "&id=$id";

                return $this->redirect($success_url);
            }
            return $this->render(
                '/common/miscellaneous/success/create.html.twig',
                ['message' => 'Product successfully created']
            );
        }

        return $this->render(
            '/admin/ui/panel/section/content/create/create.html.twig', ['form' => $form]
        );

    }


    #[Route('/product/type/list', name: 'product_type_list')]
    public function list(ProductTypeRepository $productTypeRepository): Response
    {

        $listGrid = ['title' => 'ProductType',
                     'link_id'=>'id-product-type',
                     'columns' => [['label' => 'Name',
                                    'propertyName' => 'name',
                                    'action' => 'display'],
                                   ['label' => 'Description',
                                    'propertyName' => 'description'],],
                     'createButtonConfig' => [
                         'link_id'=>' id-create-product-type',
                         'function' => 'productType',
                                              'anchorText' => 'Create ProductType']];

        $productTypes = $productTypeRepository->findAll();
        return $this->render(
            'admin/ui/panel/section/content/list/list.html.twig',
            ['entities' => $productTypes, 'listGrid' => $listGrid]
        );
    }

}