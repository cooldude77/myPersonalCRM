<?php

namespace App\Controller\Module\WebShop\External\CheckOut\Address;

use App\Form\Module\WebShop\External\CheckOut\Address\AddressMultiple;
use App\Repository\CustomerAddressRepository;
use App\Repository\CustomerRepository;
use App\Service\Module\WebShop\External\CheckOut\Address\CheckOutAddressService;
use App\Service\Module\WebShop\External\CheckOut\Address\Mapper\AddressMapper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CheckOutAddressController extends AbstractController
{

    #[Route('/checkout/addresses', name: 'web_shop_checkout_address')]
    public function list(CustomerRepository $customerRepository,
        AddressMapper $addressMapper,
        CustomerAddressRepository $customerAddressRepository,
        CheckOutAddressService $checkOutAddressService,
        Request $request
    ): Response {

        $customer = $customerRepository->findOneBy(["user" => $this->getUser()]);

        $addressesBilling = $customerAddressRepository->findBy(['customer' => $customer,
                                                                'addressType' => 'billing']);

        $addressesShipping = $customerAddressRepository->findBy(['customer' => $customer,
                                                                 'addressType' => 'shipping']);


        $dtoArray = $addressMapper->mapEntityToDto($addressesBilling, $addressesShipping);

        $form = $this->createForm(AddressMultiple::class, $dtoArray);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();


            /* if ($addressShipping != null && $addressBilling != null) {
             $checkOutAddressService->setShippingAddress($addressShipping);
             $checkOutAddressService->setBillingAddress($addressBilling);
             */

            return $this->redirectToRoute('web_shop_checkout');
        }

        return $this->render(
            'module/web_shop/external/checkout/address/checkout_address_list.html.twig',
            ['form' => $form, 'customer' => $customer]
        );

    }

}