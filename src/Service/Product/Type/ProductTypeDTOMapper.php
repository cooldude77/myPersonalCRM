<?php

namespace App\Service\Product\Type;

use App\Entity\ProductType;
use App\Form\Admin\Product\Type\DTO\ProductTypeDTO;
use App\Repository\ProductTypeRepository;

class ProductTypeDTOMapper
{

    public function __construct(private readonly ProductTypeRepository $productTypeRepository)
    {
    }

    public function mapDtoToEntityForCreate(ProductTypeDTO $productTypeDTO): ProductType
    {
        $type = $this->productTypeRepository->create();

        $type->setName($productTypeDTO->name);
        $type->setValue($productTypeDTO->value);

        return $type;

    }

}