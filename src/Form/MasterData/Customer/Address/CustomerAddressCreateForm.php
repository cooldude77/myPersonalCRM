<?php

namespace App\Form\MasterData\Customer\Address;

use App\Form\MasterData\Customer\Address\DTO\CustomerAddressDTO;
use App\Repository\PostalCodeRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CustomerAddressCreateForm extends AbstractType
{

    public function __construct(private PostalCodeRepository $postalCodeRepository)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('customerId', HiddenType::class);
        $builder->add('line1', TextType::class);
        $builder->add('line2', TextType::class);
        $builder->add('line3', TextType::class);
        $builder->add('postalCodeId', ChoiceType::class, [// validation message if the data
                                                       // transformer fails
                                                       'choices' => $this->fill()]);
        $builder->add(
            'addressType', ChoiceType::class,
            [
                'choices' => [
                    'Shipping' => 'shipping',
                    'Billing' => 'billing',
                ],
                'multiple' => false,
                'expanded' => true,
            ]
        );
        $builder->add('save', SubmitType::class);
    }

    private function fill(): array
    {
        $selectArray = [];
        $postalCodes = $this->postalCodeRepository->findAll();
        foreach ($postalCodes as $bu) {

            $selectArray[$bu->getCode()] = $bu->getId();
        }
        return $selectArray;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => CustomerAddressDTO::class]);
    }

    public function getBlockPrefix(): string
    {
        return 'customer_address_create_form';
    }
}