<?php

namespace App\Service\Module\WebShop\External\Order\Mapper;

use App\Entity\OrderHeader;
use App\Form\Module\WebShop\External\Order\DTO\OrderObjectDTO;
use App\Service\Module\WebShop\External\Order\Mapper\Components\OrderAddressDtoEntityMapper;
use App\Service\Module\WebShop\External\Order\Mapper\Components\OrderHeaderDtoEntityMapper;
use App\Service\Module\WebShop\External\Order\Mapper\Components\OrderItemDtoEntityMapper;
use App\Service\Module\WebShop\External\Order\Mapper\Components\OrderPaymentDtoEntityMapper;

class OrderDTOMapper
{

    private $orderHeader;

    public function __construct(
        private readonly OrderHeaderDtoEntityMapper $orderHeaderDtoEntityMapper,
        private readonly OrderItemDtoEntityMapper $orderItemDtoEntityMapper,
        private readonly OrderAddressDtoEntityMapper $orderAddressDtoEntityMapper,
        private readonly OrderPaymentDtoEntityMapper $orderPaymentDtoEntityMapper
    ) {
    }

    public function mapToEntityForCreate(OrderObjectDTO $orderObjectDTO): OrderHeader
    {


    }

    public function mapToEntityForUpdate(OrderObjectDTO $orderObjectDTO)
    {

    }

}