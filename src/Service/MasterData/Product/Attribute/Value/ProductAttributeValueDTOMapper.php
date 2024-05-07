<?php

namespace App\Service\MasterData\Product\Attribute\Value;

use App\Entity\ProductAttribute;
use App\Entity\ProductAttributeValue;
use App\Form\MasterData\Product\Attribute\Value\DTO\ProductAttributeValueDTO;
use App\Repository\ProductAttributeRepository;
use App\Repository\ProductAttributeValueRepository;

readonly class ProductAttributeValueDTOMapper
{

    public function __construct(private ProductAttributeRepository $productAttributeRepository,
        private ProductAttributeValueRepository $productAttributeValueRepository
    ) {
    }

    public function mapDtoToEntityForCreate(ProductAttributeValueDTO $productAttributeValueDTO
    ): ProductAttributeValue {
        /** @var ProductAttribute $productAttribute */

        $productAttribute = $this->productAttributeRepository->findOneBy(
            ['id' => $productAttributeValueDTO->productAttributeId]
        );

        $attribute = $this->productAttributeValueRepository->create($productAttribute);

        $attribute->setName($productAttributeValueDTO->name);
        $attribute->setValue($productAttributeValueDTO->value);

        $attribute->setProductAttribute($productAttribute);

        return $attribute;

    }

    public function mapDtoToEntityForUpdate(ProductAttributeValueDTO $productAttributeValueDTO,
        ProductAttributeValue $productAttributeValueEntity): ProductAttributeValue
    {

        $productAttributeValueEntity->setName($productAttributeValueDTO->name);
        $productAttributeValueEntity->setValue($productAttributeValueDTO->value);

        return $productAttributeValueEntity;
    }

}