<?php

namespace App\Controller\Module\WebShop\External\CheckOut\Address;

use App\Form\Module\WebShop\External\Address\AddressChooseFromMultipleForm;
use App\Form\Module\WebShop\External\Address\AddressCreateForm;
use App\Form\Module\WebShop\External\Address\DTO\AddressCreateAndChooseDTO;
use App\Repository\CustomerAddressRepository;
use App\Repository\CustomerRepository;
use App\Service\Module\WebShop\External\CheckOut\Address\CheckOutAddressService;
use App\Service\Module\WebShop\External\CheckOut\Address\CustomerFromUserFinder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;

class AddressController extends AbstractController
{


    #[Route('/checkout/addresses', name: 'web_shop_checkout_address')]
    public function main(CustomerRepository $customerRepository,
        CustomerAddressRepository $customerAddressRepository,
        CheckOutAddressService $checkOutAddressService,
    ): Response {

        $customer = $customerRepository->findOneBy(["user" => $this->getUser()]);

        $addressesShipping = $customerAddressRepository->findBy(['customer' => $customer,
                                                                 'addressType' => 'shipping']);

        if ($addressesShipping == null) {
            return $this->redirectToRoute(
                'web_shop_checkout_address_create', ['id' => 'customer', 'type' => 'shipping']
            );
        }

        $addressesBilling = $customerAddressRepository->findBy(['customer' => $customer,
                                                                'addressType' => 'billing']);

        if ($addressesBilling == null) {
            return $this->redirectToRoute(
                'web_shop_checkout_address_create', ['id' => 'customer', 'type' => 'billing']
            );
        }

        // addresses exist but not yet chosen
        if ($checkOutAddressService->isShippingAddressSet()) {
            return $this->redirectToRoute(
                'web_shop_checkout_choose_address_from_list',
                ['id' => 'customer', 'type' => 'shipping']
            );
        }
        if ($checkOutAddressService->isBillingAddressSet()) {
            return $this->redirectToRoute(
                'web_shop_checkout_choose_address_from_list',
                ['id' => 'customer', 'type' => 'billing']
            );
        }

        // everything ok, go back to check out
        return $this->redirectToRoute('web_shop_checkout');
    }

    #[Route('/checkout/address/create', name: 'web_shop_checkout_address_create')]
    public function create(RouterInterface $router, Request $request,
        CustomerFromUserFinder $customerFromUserFinder,
        CheckOutAddressService $checkOutAddressService
    ): Response {


        $dto = new AddressCreateAndChooseDTO();

        $dto->address->customerId = $customerFromUserFinder->getLoggedInCustomer()->getId();

        if ($request->get('type') != null) {
            $dto->address->addressType = $request->get('type');
        }

        $form = $this->createForm(AddressCreateForm::class, $dto);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var AddressCreateAndChooseDTO $data */
            $data = $form->getData();
            $data->address->pinCodeId = $form->get('address')->get('pinCode')->getData()->getId();

            $checkOutAddressService->save($data);

            return $this->redirectToRoute('web_shop_checkout');
        }
        // if it is a form then just display it raw here
        return $this->render(
            'admin/ui/panel/section/content/create/create.html.twig', ['form' => $form]
        );

    }

    /**
     * @param CustomerRepository        $customerRepository
     * @param CustomerAddressRepository $customerAddressRepository
     * @param CustomerFromUserFinder    $customerFromUserFinder
     * @param CheckOutAddressService    $checkOutAddressService
     * @param AddressChooseMapper       $addressChooseMapper
     * @param Request                   $request
     *
     * @return Response
     * @throws \App\Exception\Module\WebShop\External\CheckOut\Address\UserNotLoggedInException
     *
     *
     * Choose from multiple addresses
     */
    #[Route('/checkout/addresses/choose', name: 'web_shop_checkout_choose_address_from_list')]
    public function chooseFromList(CustomerRepository $customerRepository,
        CustomerAddressRepository $customerAddressRepository,
        CustomerFromUserFinder $customerFromUserFinder,
        CheckOutAddressService $checkOutAddressService,
        AddressChooseMapper $addressChooseMapper,
        Request $request
    ): Response {
        $customer = $customerFromUserFinder->getLoggedInCustomer();

        $addresses = $customerAddressRepository->findBy(['customer' => $customer,
                                                         'addressType' => $request->get('type')]);

        $addressesDTO = $addressChooseMapper->mapAddressesToDto($addresses);


        $form = $this->createForm(AddressChooseFromMultipleForm::class, $addressesDTO);

        return $this->render(
            'module/web_shop/external/checkout/address/page/checkout_address_billing_page.html.twig',
            ['form' => $form]
        );
    }

}