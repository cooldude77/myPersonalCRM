<?php

namespace App\Controller\Module\WebShop\External\Address;

use App\Form\Module\WebShop\External\Address\Existing\DTO\AddressChooseExistingMultipleDTO;
use App\Form\Module\WebShop\External\Address\Existing\DTO\AddressChooseExistingSingleDTO;
use App\Service\Module\WebShop\External\Address\CheckOutAddressSession;

readonly class CheckoutAddressChooseParser
{
    public function __construct(
        private CheckOutAddressSession $checkOutAddressSession
    ) {
    }

    public function setAddressInSession(AddressChooseExistingMultipleDTO $multipleDTO,
        string $addressType
    ):
    void {
        /** @var AddressChooseExistingSingleDTO $address */
        foreach ($multipleDTO->addresses as $address) {
            if ($address->isChosen) {
                if ($addressType == 'shipping') {
                    $this->checkOutAddressSession->setShippingAddress($address->id);
                } elseif ($addressType == 'billing') {
                    $this->checkOutAddressSession->setBillingAddress($address->id);
                }
                break;
            }
        }


    }
}