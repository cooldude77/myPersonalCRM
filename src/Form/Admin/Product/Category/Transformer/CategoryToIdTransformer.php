<?php
// src/Form/DataTransformer/CategoryToNumberTransformer.php
namespace App\Form\Admin\Product\Category\Transformer;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class CategoryToIdTransformer implements DataTransformerInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    )
    {
    }

    /**
     * Transforms an object (category) to a string (number).
     *
     * @param Category|null $category
     */
    public function transform($category): string
    {
        if (null === $category) {
            return '';
        }

        return $category->getId();
    }

    /**
     * Transforms a string (number) to an object (category).
     *
     * @param string $id
     * @throws TransformationFailedException if object (category) is not found.
     */
    public function reverseTransform($id): ?Category
    {
        // no category number? It's optional, so that's ok
        if (!$id) {
            return null;
        }

        $category = $this->entityManager
            ->getRepository(Category::class)
            // query for the category with this id
            ->find($id);

        if (null === $category) {
            // causes a validation error
            // this message is not shown to the user
            // see the invalid_message option
            throw new TransformationFailedException(sprintf(
                'An category with number "%s" does not exist!',
                $id
            ));
        }

        return $category;
    }
}