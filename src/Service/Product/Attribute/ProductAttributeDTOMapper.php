<?php

namespace App\Service\Product\Attribute;

use App\Entity\ProductAttributeType;
use App\Form\Admin\Product\Attribute\DTO\ProductAttributeDTO;
use App\Repository\ProductAttributeRepository;

class ProductAttributeDTOMapper
{

    private ProductAttributeRepository $attributeRepository;

    public function __construct(ProductAttributeRepository $attributeRepository)
    {
        $this->attributeRepository = $attributeRepository;
    }

    public function mapDtoToEntity(\Symfony\Component\Form\FormInterface $form): \App\Entity\ProductAttribute
    {
        $attribute = $this->attributeRepository->create();
        /** @var ProductAttributeDTO $dto */
        $dto = $form->getData();
        /** @var ProductAttributeType $type */
        $type  = $form->get('attributeType')->getData();

        $attribute->setName($dto->name);
        $attribute->setDescription($dto->description);

        $attribute->setAttributeType($type);

        return $attribute;

    }

}