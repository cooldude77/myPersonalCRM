<?php

namespace App\Service\Product\Attribute\Value;

use App\Entity\ProductAttribute;
use App\Entity\ProductAttributeValue;
use App\Form\Admin\Product\Attribute\Value\DTO\ProductAttributeValueDTO;
use App\Repository\ProductAttributeRepository;
use App\Repository\ProductAttributeValueRepository;

class ProductAttributeValueDTOMapper
{

    public function __construct(private readonly ProductAttributeRepository $productAttributeRepository,
        private readonly ProductAttributeValueRepository $productAttributeValueRepository
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
        $attribute->setValue($productAttributeValueDTO->description);

        $attribute->setProductAttribute($productAttribute);

        return $attribute;

    }

}