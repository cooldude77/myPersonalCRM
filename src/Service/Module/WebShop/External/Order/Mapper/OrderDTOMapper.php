<?php

namespace App\Service\Module\WebShop\External\Order\Mapper;

use App\Entity\OrderHeader;
use App\Form\Module\WebShop\External\Order\DTO\Components\Components\OrderItemDTO;
use App\Form\Module\WebShop\External\Order\DTO\OrderObjectDTO;
use App\Repository\CustomerRepository;
use App\Repository\OrderAddressRepository;
use App\Repository\OrderHeaderRepository;
use App\Repository\OrderItemRepository;
use App\Repository\OrderPaymentRepository;
use App\Repository\ProductRepository;
use App\Service\Module\WebShop\External\Order\Mapper\Components\OrderAddressMapper;
use App\Service\Module\WebShop\External\Order\Mapper\Components\OrderHeaderMapper;
use App\Service\Module\WebShop\External\Order\Mapper\Components\OrderItemMapper;
use App\Service\Module\WebShop\External\Order\Mapper\Components\OrderPaymentMapper;
use Doctrine\Common\Collections\ArrayCollection;

class OrderDTOMapper
{

    private $orderHeader;

    public function __construct(private readonly CustomerRepository $customerRepository,
        private readonly ProductRepository $productRepository,
        private readonly OrderHeaderRepository $orderHeaderRepository,
        private readonly OrderItemRepository $orderItemRepository,
        private readonly OrderAddressRepository $orderAddressRepository,
        private readonly OrderPaymentRepository $orderPaymentRepository,
        private readonly  OrderHeaderMapper $orderHeaderMapper,
        private readonly   OrderItemMapper $orderItemMapper,
        private readonly    OrderAddressMapper $orderAddressMapper,
        private readonly    OrderPaymentMapper $orderPaymentMapper
    ) {
    }

    public function mapToEntityForCreate(OrderObjectDTO $orderObjectDTO): OrderHeader
    {

        $this->orderHeader = $this->orderHeaderMapper->mapToEntityForCreate
        ($orderObjectDTO->orderHeaderDTO);

        $this0





    }

    public function mapToEntityForUpdate(OrderObjectDTO $orderObjectDTO)
    {

    }

}