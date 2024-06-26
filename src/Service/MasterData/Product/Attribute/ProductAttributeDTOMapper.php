<?php

namespace App\Service\MasterData\Product\Attribute;

use App\Entity\ProductAttribute;
use App\Entity\ProductAttributeType;
use App\Form\MasterData\Product\Attribute\DTO\ProductAttributeDTO;
use App\Repository\ProductAttributeRepository;
use App\Repository\ProductAttributeTypeRepository;

class ProductAttributeDTOMapper
{

    public function __construct(private ProductAttributeTypeRepository $productAttributeTypeRepository,
        private ProductAttributeRepository $productAttributeRepository
    ) {
    }

    public function mapDtoToEntity(ProductAttributeDTO $productAttributeDTO
    ): ProductAttribute {
        $attribute = $this->productAttributeRepository->create();
        /** @var ProductAttributeType $type */
        $type = $this->productAttributeTypeRepository->findOneBy(
            ['id' => $productAttributeDTO->productAttributeTypeId]
        );

        $attribute->setName($productAttributeDTO->name);
        $attribute->setDescription($productAttributeDTO->description);

        $attribute->setProductAttributeType($type);

        return $attribute;

    }

    public function mapDtoToEntityForEdit(ProductAttributeDTO $productAttributeDTO,
        ProductAttribute $productAttributeEntity
    ) {


        $productAttributeEntity->setName($productAttributeDTO->name);
        $productAttributeEntity->setDescription($productAttributeDTO->description);

        return $productAttributeEntity;


    }

}