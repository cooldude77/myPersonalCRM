<?php

namespace App\Service\Module\WebShop\External\CheckOut\Address;

use App\Repository\CustomerAddressRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RequestStack;

class CheckOutAddressService
{
    public const BILLING_ADDRESS_SET_ID ="BILLING_ADDRESS_SET_ID";
    public const SHIPPING_ADDRESS_SET_ID ="SHIPPING_ADDRESS_SET_ID";

    public function __construct(private readonly Security $security,
      private  readonly RequestStack $requestStack,
        private  readonly CustomerAddressRepository $customerAddressRepository,
    ) {

    }

    public function areAddressesProper(): bool
    {


        $customer = $this->customerRepository->findOneBy(['user' => $this->security->getUser()]);
        $addresses = $this->customerAddressRepository->findBy(['customer' => $customer]);
        // todo:
        return true;

    }

    public function checkShippingAddressSet()
    {
  
    }

    public function setShippingAddress(\App\Entity\CustomerAddress $addressShipping):void
    {
        $this->requestStack->getSession()->set(self::SHIPPING_ADDRESS_SET_ID,
            $addressShipping->getId());
          
    }
    public function setBillingAddress(\App\Entity\CustomerAddress $addressBilling):void
    {
        $this->requestStack->getSession()->set(self::BILLING_ADDRESS_SET_ID,
            $addressBilling->getId());
          
    }

}