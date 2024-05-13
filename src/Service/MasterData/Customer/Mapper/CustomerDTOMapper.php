<?php

namespace App\Service\MasterData\Customer\Mapper;

use App\Entity\Category;
use App\Entity\Customer;
use App\Entity\User;
use App\Form\MasterData\Customer\DTO\CustomerDTO;
use App\Repository\CustomerRepository;
use App\Repository\SalutationRepository;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CustomerDTOMapper
{

    public function __construct(private CustomerRepository $customerRepository,
        private SalutationRepository $salutationRepository,
        private UserPasswordHasherInterface $userPasswordHasher
    ) {
    }

    public function mapToEntityForCreate(FormInterface $form): Customer
    {
        /** @var Category $category */
        $salutation = $this->salutationRepository->find($form->get('salutationId')->getData());
        $customer = $this->customerRepository->create($salutation);

        /** @var CustomerDTO $customerDTO */
        $customerDTO = $form->getData();

        $customer->setFirstName($customerDTO->firstName);
        $customer->setMiddleName($customerDTO->middleName);
        $customer->setLastName($customerDTO->lastName);
        $customer->setGivenName($customerDTO->givenName);
        $customer->setEmail($customerDTO->email);
        $customer->setPhoneNumber($customerDTO->phoneNumber);

        $customer->setUser($this->createUser($customerDTO,$customer));

        return $customer;
    }

    public function createUser(CustomerDTO $customerDTO, Customer $customer): User
    {
        $user = new User();
        $user->setLogin($customer->getEmail());

        // encode the plain password
        $user->setPassword(
            $this->userPasswordHasher->hashPassword(
                $user,
                $customerDTO->plainPassword
            )
        );

        return $user;
    }

    public function mapToEntityForEdit(FormInterface $form, Customer $customer): Customer
    {
        /** @var Category $category */
        $salutation = $this->salutationRepository->find($form->get('salutationId')->getData());

        $customerDTO = $form->getData();

        $customer->setSalutation($salutation);

        $customer->setFirstName($customerDTO->firstName);
        $customer->setMiddleName($customerDTO->middleName);
        $customer->setLastName($customerDTO->lastName);
        $customer->setGivenName($customerDTO->givenName);

        return $customer;

    }
}