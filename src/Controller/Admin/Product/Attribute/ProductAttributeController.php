<?php
// src/Controller/ProductController.php
namespace App\Controller\Admin\Product\Attribute;

// ...
use App\Entity\ProductAttribute;
use App\Form\Admin\Product\Attribute\DTO\ProductAttributeDTO;
use App\Form\Admin\Product\Attribute\ProductAttributeCreateForm;
use App\Repository\ProductTypeRepository;
use App\Service\Product\Attribute\ProductAttributeDTOMapper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductAttributeController extends AbstractController
{
    #[Route('/product/attribute/create', name: 'product_attribute_create')]
    public function create(ProductAttributeDTOMapper $mapper, EntityManagerInterface $entityManager,
        Request $request
    ): Response {
        $productAttributeDTO = new ProductAttributeDTO();
if($request->get('type')==3)
    $productAttributeDTO->type=3;

        $form = $this->createForm(ProductAttributeCreateForm::class, $productAttributeDTO);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $productAttribute = $mapper->mapDtoToEntity($form->getData());

            $entityManager->persist($productAttribute);
            $entityManager->flush();

            if ($request->get('_redirect_upon_success_url')) {
                $this->addFlash(
                    'success', "Product created successfully"
                );

                $id = $productAttribute->getId();
                $success_url = $request->get('_redirect_upon_success_url') . "&id=$id";

                return $this->redirect($success_url);
            }
            return $this->render(
                '/common/miscellaneous/success/create.html.twig',
                ['message' => 'Product successfully created']
            );
        }

        $formErrors = $form->getErrors(true);
        return $this->render(
            '/admin/ui/panel/section/content/create/create.html.twig', ['form' => $form]
        );

    }


    #[Route('/product/{type}/attribute/list', name: 'product_type_attribute_list')]
    public function listProductTypeAttribute(ProductTypeRepository $productTypeRepository): Response
    {

        $list = $productTypeRepository->findAll();

        return $this->render('admin/product/type/attribute/list.html.twig', ['list' => $list]);

    }


}