<?php

namespace App\Controller\Module\WebShop\External\CheckOut;

use App\Repository\CustomerAddressRepository;
use App\Repository\CustomerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class CheckOutAddressController extends AbstractController
{

    public function list(CustomerRepository $customerRepository,
        CustomerAddressRepository $customerAddressRepository
    ): Response {

        $customer = $customerRepository->findOneBy(["user" => $this->getUser()]);

        $addressBilling = $customerAddressRepository->findOneBy(['customer' => $customer,
                                                                 'addressType' => 'billing']);

        $addressShipping = $customerAddressRepository->findOneBy(['customer' => $customer,
                                                                  'addressType' => 'shipping']);

        return $this->render(
            'module/web_shop/external/checkout/address/checkout_address_list.html.twig',
            ['billingAddress' => $addressBilling, 'shippingAddress' => $addressShipping,'customer'=>$customer]
        );

    }

}