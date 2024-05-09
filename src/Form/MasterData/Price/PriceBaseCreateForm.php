<?php

namespace App\Form\MasterData\Price;

use App\Form\MasterData\Price\DTO\PriceBaseDTO;
use App\Repository\CurrencyRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PriceBaseCreateForm extends AbstractType
{

    public function __construct(private CurrencyRepository $currencyRepository)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('productId', TextType::class);
        $builder->add('price', TextType::class);
        $builder->add('currencyId', ChoiceType::class, [// validation message if the data
                                                        // transformer fails
                                                        'choices' => $this->fill()]);

        $builder->add('save', SubmitType::class);
    }

    private function fill(): array
    {
        $selectArray = [];
        $currencies = $this->currencyRepository->findAll();
        foreach ($currencies as $bu) {

            $selectArray[$bu->getCode()] = $bu->getId();
        }
        return $selectArray;
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => PriceBaseDTO::class]);
    }

    public function getBlockPrefix(): string
    {

        return 'price_base_create_form';
    }
}