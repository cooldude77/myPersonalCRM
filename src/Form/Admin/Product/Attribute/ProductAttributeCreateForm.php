<?php

namespace App\Form\Admin\Product\Attribute;

use App\Form\Admin\Product\Attribute\DTO\ProductAttributeDTO;
use App\Repository\ProductAttributeTypeRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductAttributeCreateForm extends AbstractType
{
    public function __construct(private ProductAttributeTypeRepository $productAttributeTypeRepository
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('name', TextType::class);
        $builder->add('description', TextType::class);
        $builder->add(
            'productAttributeTypeId', ChoiceType::class, [// validation message if the data transformer fails
                                        'choices' => $this->fill()]
        );

        $builder->add('save', SubmitType::class);
    }

    private function fill(): array
    {
        $selectArray = [];
        $productAttributeTypes = $this->productAttributeTypeRepository->findAll();
        foreach ($productAttributeTypes as $bu) {

            $selectArray[$bu->getName()] = $bu->getId();
        }
        return $selectArray;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => ProductAttributeDTO::class]);
    }
}