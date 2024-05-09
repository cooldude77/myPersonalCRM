<?php

namespace App\Form\MasterData\Customer\Address;

use App\Form\MasterData\Customer\Address\DTO\CustomerAddressDTO;
use App\Repository\PinCodeRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CustomerAddressEditForm extends AbstractType
{


    public function __construct(private PinCodeRepository $pinCodeRepository)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('customerId',HiddenType::class);
        $builder->add('line1',TextType::class);
        $builder->add('pinCodeId',ChoiceType::class, [// validation message if the data
                                                      // transformer fails
                                                      'choices' => $this->fill()]);

        $builder->add('save', SubmitType::class);
    }
    private function fill(): array
    {
        $selectArray = [];
        $pinCodes = $this->pinCodeRepository->findAll();
        foreach ($pinCodes as $bu) {

            $selectArray[$bu->getPinCode()] = $bu->getId();
        }
        return $selectArray;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => CustomerAddressDTO::class]);
    }

    public function getBlockPrefix(): string
    {
        return 'customer_address_edit_form';
    }
}