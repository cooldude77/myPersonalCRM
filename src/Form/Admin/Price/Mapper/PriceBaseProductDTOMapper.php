<?php

namespace App\Form\Admin\Price\Mapper;

use App\Form\Admin\Price\DTO\PriceBaseProductDTO;
use App\Repository\CurrencyRepository;
use App\Repository\PriceBaseProductRepository;
use App\Repository\ProductRepository;

class PriceBaseProductDTOMapper
{

    private ProductRepository $productRepository;
    private CurrencyRepository $currencyRepository;
    private PriceBaseProductRepository $priceBaseProductRepository;

    public function __construct(ProductRepository  $productRepository,
                                CurrencyRepository $currencyRepository,
    PriceBaseProductRepository $priceBaseProductRepository)
    {
        $this->productRepository = $productRepository;
        $this->currencyRepository = $currencyRepository;
        $this->priceBaseProductRepository = $priceBaseProductRepository;
    }

    public function map(PriceBaseProductDTO $priceBaseProductDTO): \App\Entity\PriceBaseProduct
    {

        $product = $this->productRepository->findOneBy(['id'=>$priceBaseProductDTO->productId]);
        $currency = $this->currencyRepository->findOneBy(['id'=>$priceBaseProductDTO->currencyId]);
        $priceBaseProduct  = $this->priceBaseProductRepository->create($product,$currency);
        $priceBaseProduct->setPrice($priceBaseProductDTO->price);
        return $priceBaseProduct;

    }


}