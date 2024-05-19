<?php
// src/Form/DataTransformer/OrderHeaderToNumberTransformer.php
namespace App\Form\Module\WebShop\Admin\Order\Header\Transformer;

use App\Entity\OrderHeader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class OrderHeaderToIdTransformer implements DataTransformerInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    )
    {
    }

    /**
     * Transforms an object (orderHeader) to a string (number).
     *
     * @param OrderHeader|null $orderHeader
     */
    public function transform($orderHeader): string
    {
        if (null === $orderHeader) {
            return '';
        }

        return $orderHeader->getId();
    }

    /**
     * Transforms a string (number) to an object (orderHeader).
     *
     * @param string $value
     *
     * @throws TransformationFailedException if object (orderHeader) is not found.
     */
    public function reverseTransform($value): ?OrderHeader
    {
        // no orderHeader number? It's optional, so that's ok
        if (!$value) {
            return null;
        }

        $orderHeader = $this->entityManager
            ->getRepository(OrderHeader::class)
            // query for the orderHeader with this id
            ->find($value);

        if (null === $orderHeader) {
            // causes a validation error
            // this message is not shown to the user
            // see the invalid_message option
            throw new TransformationFailedException(sprintf(
                'An orderHeader with number "%s" does not exist!',
                $value
            ));
        }

        return $orderHeader;
    }
}