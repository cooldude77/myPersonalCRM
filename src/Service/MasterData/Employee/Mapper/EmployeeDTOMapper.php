<?php

namespace App\Service\MasterData\Employee\Mapper;

use App\Entity\Category;
use App\Entity\Employee;
use App\Entity\User;
use App\Form\MasterData\Employee\DTO\EmployeeDTO;
use App\Repository\EmployeeRepository;
use App\Repository\SalutationRepository;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class EmployeeDTOMapper
{

    public function __construct(private EmployeeRepository $employeeRepository,
        private SalutationRepository $salutationRepository,
        private UserPasswordHasherInterface $userPasswordHasher
    ) {
    }

    public function mapToEntityForCreate(FormInterface $form): Employee
    {
        /** @var Category $category */
        $salutation = $this->salutationRepository->find($form->get('salutationId')->getData());
        $employee = $this->employeeRepository->create($salutation);

        /** @var EmployeeDTO $employeeDTO */
        $employeeDTO = $form->getData();

        $employee->setFirstName($employeeDTO->firstName);
        $employee->setMiddleName($employeeDTO->middleName);
        $employee->setLastName($employeeDTO->lastName);
        $employee->setGivenName($employeeDTO->givenName);
        $employee->setEmail($employeeDTO->email);
        $employee->setPhoneNumber($employeeDTO->phoneNumber);

        $employee->setUser($this->createUser($employeeDTO,$employee));

        return $employee;
    }

    public function createUser(EmployeeDTO $employeeDTO, Employee $employee):User
    {
        $user = new User();
        $user->setLogin($employee->getEmail());

        // encode the plain password
        $user->setPassword(
            $this->userPasswordHasher->hashPassword(
                $user,
               $employeeDTO->plainPassword
            )
        );

       return $user;
    }

    public function mapToEntityForEdit(FormInterface $form, Employee $employee): Employee
    {
        /** @var Category $category */
        $salutation = $this->salutationRepository->find($form->get('salutationId')->getData());

        $employeeDTO = $form->getData();

        $employee->setSalutation($salutation);

        $employee->setFirstName($employeeDTO->firstName);
        $employee->setMiddleName($employeeDTO->middleName);
        $employee->setLastName($employeeDTO->lastName);
        $employee->setGivenName($employeeDTO->givenName);

        return $employee;

    }
}