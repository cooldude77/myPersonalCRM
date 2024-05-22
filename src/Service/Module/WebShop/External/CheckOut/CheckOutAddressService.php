<?php

namespace App\Service\Module\WebShop\External\CheckOut;

use App\Repository\CustomerAddressRepository;
use App\Repository\CustomerRepository;
use Symfony\Bundle\SecurityBundle\Security;

class CheckOutAddressService
{

    public function __construct(private readonly Security $security,
        private readonly CustomerRepository $customerRepository,
        private readonly CustomerAddressRepository $customerAddressRepository
    ) {

    }

    public function areAddressesProper(): bool
    {


        $customer = $this->customerRepository->findOneBy(['user' => $this->security->getUser()]);
        $addresses = $this->customerAddressRepository->findBy(['customer' => $customer]);
        // todo:
        return true;

    }

}