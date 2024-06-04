<?php

namespace App\Service\Module\WebShop\External\CheckOut\Address;

use App\Entity\User;
use App\Exception\Module\WebShop\External\CheckOut\Address\UserNotLoggedInException;
use App\Repository\CustomerRepository;
use Symfony\Bundle\SecurityBundle\Security;

class CustomerFromUserFinder
{

    public function __construct(private readonly Security $security, private
    readonly CustomerRepository $customerRepository
    ) {
    }

    public function getLoggedInCustomer()
    {
        if ($this->security->getUser() != null) {
            throw new UserNotLoggedInException();
        }

        /** @var User $user */
        $user = $this->security->getUser();

        return $this->customerRepository->findOneBy(['user' => $user]);

    }
}