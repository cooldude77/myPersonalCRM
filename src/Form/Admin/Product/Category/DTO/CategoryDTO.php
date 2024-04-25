<?php

namespace App\Form\Admin\Product\Category\DTO;

use Symfony\Component\Validator\Constraints as Assert;
class CategoryDTO
{

    /**
     * @var string|null
     */
    #[Assert\Length(
        min: 1,
        max: 200,
        maxMessage: 'Length cannot exceed 200 '
    )]
    #[Assert\Regex(
        pattern:'/^[a-zA-Z0-9]$/',
        match:true,
        message: 'Only characters and numbers are allowed'
    )]
    public ?string $name =null;

    /**
     * @var string|null
     */

    #[Assert\Length(
        min: 1,
        max: 200,
        maxMessage: 'Length cannot exceed 200 '
    )]
    public ?string $description =null;

    public ?string $parent = null;
    public ?int $id = -1;
}