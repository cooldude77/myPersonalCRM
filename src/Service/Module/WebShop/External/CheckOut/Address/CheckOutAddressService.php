<?php

namespace App\Service\Module\WebShop\External\CheckOut\Address;

use App\Entity\CustomerAddress;
use App\Form\Module\WebShop\External\Address\DTO\AddressCreateAndChooseDTO;
use App\Repository\CustomerAddressRepository;
use App\Service\Security\User\Customer\CustomerService;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RequestStack;

class CheckOutAddressService
{
    public const BILLING_ADDRESS_ID = "BILLING_ADDRESS_SET_ID";
    public const SHIPPING_ADDRESS_ID = "SHIPPING_ADDRESS_SET_ID";

    public function __construct(private readonly Security $security,
        private readonly RequestStack $requestStack,
        private readonly CustomerService $customerService,
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

    public function checkShippingAddressSet()
    {

    }


    public function setBillingAddress(int $id): void
    {
        $this->requestStack->getSession()->set(self::BILLING_ADDRESS_ID, $id);

    }

    public function setShippingAddress(int $id): void
    {
        $this->requestStack->getSession()->set(self::SHIPPING_ADDRESS_ID, $id);

    }

    public function isShippingAddressSet(): bool
    {
        // todo: verify id
        return $this->requestStack->getSession()->get(self::SHIPPING_ADDRESS_ID) != null;

    }

    public function isBillingAddressSet(): bool
    {

        // todo: verify id
        return $this->requestStack->getSession()->get(self::BILLING_ADDRESS_ID) != null;


    }

    public function save(AddressCreateAndChooseDTO $dto)
    {

        $this->customerService->mapAndPersist($dto->address);
        $this->customerService->flush();

        $this->setChosen($dto->isChosen,$dto->address->addressType  );

    }

    private function setChosen(bool $isChosen,$type):void
    {

        $key = $type == "billing" ? self::BILLING_ADDRESS_ID : self::SHIPPING_ADDRESS_ID;
        $this->requestStack->getSession()->set($key,$isChosen);
    }

    public function validateBeforeOrder()
    {
        // todo
    }

    public function getBillingAddress():CustomerAddress
    {
        return $this->customerAddressRepository->find(
            $this->requestStack->getSession()->get(self::BILLING_ADDRESS_ID)
        );
    }

    public function getShippingAddress():CustomerAddress
    {
        return $this->customerAddressRepository->find(
            $this->requestStack->getSession()->get(self::SHIPPING_ADDRESS_ID)
        );
    }

}