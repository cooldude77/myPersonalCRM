<?php

namespace App\Form\MasterData\Price\Mapper;

use App\Entity\PriceBase;
use App\Form\MasterData\Price\DTO\PriceBaseDTO;
use App\Repository\CurrencyRepository;
use App\Repository\PriceBaseRepository;
use App\Repository\ProductRepository;

class PriceBaseDTOMapper
{

    private ProductRepository $productRepository;
    private CurrencyRepository $currencyRepository;
    private PriceBaseRepository $priceBaseProductRepository;

    public function __construct(ProductRepository $productRepository,
        CurrencyRepository $currencyRepository, PriceBaseRepository $priceBaseProductRepository
    ) {
        $this->productRepository = $productRepository;
        $this->currencyRepository = $currencyRepository;
        $this->priceBaseProductRepository = $priceBaseProductRepository;
    }

    public function mapDtoToEntity(PriceBaseDTO $priceBaseProductDTO): PriceBase
    {

        $product = $this->productRepository->findOneBy(['id' => $priceBaseProductDTO->productId]);
        $currency = $this->currencyRepository->findOneBy(['id' => $priceBaseProductDTO->currencyId]
        );
        $priceBase = $this->priceBaseProductRepository->create($product, $currency);
        $priceBase->setPrice($priceBaseProductDTO->price);
        return $priceBase;

    }

    public function mapDtoToEntityForEdit(PriceBaseDTO $priceBaseProductDTO, ?PriceBase
    $priceBase):PriceBase
    {

        $priceBase->setPrice($priceBaseProductDTO->price);

        return $priceBase;
    }


}