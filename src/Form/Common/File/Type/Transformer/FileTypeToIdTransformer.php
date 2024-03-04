<?php
// src/Form/DataTransformer/FileTypeToNumberTransformer.php
namespace App\Form\Common\File\Type\Transformer;

use App\Entity\FileType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class FileTypeToIdTransformer implements DataTransformerInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    )
    {
    }

    /**
     * Transforms an object (fileType) to a string (number).
     *
     * @param FileType|null $fileType
     */
    public function transform($fileType): string
    {
        if (null === $fileType) {
            return '';
        }

        return $fileType->getId();
    }

    /**
     * Transforms a string (number) to an object (fileType).
     *
     * @param string $id
     * @throws TransformationFailedException if object (fileType) is not found.
     */
    public function reverseTransform($id): ?FileType
    {
        // no fileType number? It's optional, so that's ok
        if (!$id) {
            return null;
        }

        $fileType = $this->entityManager
            ->getRepository(FileType::class)
            // query for the fileType with this id
            ->find($id);

        if (null === $fileType) {
            // causes a validation error
            // this message is not shown to the user
            // see the invalid_message option
            throw new TransformationFailedException(sprintf(
                'An fileType with number "%s" does not exist!',
                $id
            ));
        }

        return $fileType;
    }
}