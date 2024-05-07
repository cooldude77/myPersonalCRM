<?php

namespace App\Service\MasterData\Product\Type;

use App\Entity\ProductType;
use App\Form\MasterData\Product\Type\DTO\ProductTypeDTO;
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
        $type->setDescription($productTypeDTO->value);

        return $type;

    }

    public function mapDtoToEntityForUpdate(ProductTypeDTO $productTypeDTO,
        ProductType $productTypeEntity
    ) {

        $productTypeEntity->setName($productTypeDTO->name);
        $productTypeEntity->setDescription($productTypeDTO->value);


        return $productTypeEntity;

    }

}