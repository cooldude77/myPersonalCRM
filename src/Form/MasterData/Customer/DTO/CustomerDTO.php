<?php

namespace App\Form\MasterData\Customer\DTO;

class CustomerDTO
{
    public ?int $id = -1;
    public ?string $firstName = null;
    public ?string $middleName = null;
    public ?string $lastName = null;
    public ?string $givenName = null;

    public ?string $code = null;
    public ?int $salutationId = -1;

}