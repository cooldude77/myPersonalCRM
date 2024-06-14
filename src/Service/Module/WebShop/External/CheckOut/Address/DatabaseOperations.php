<?php

namespace App\Service\Module\WebShop\External\CheckOut\Address;

use Doctrine\ORM\EntityManagerInterface;

class DatabaseOperations
{

    public function __construct(private readonly EntityManagerInterface $entityManager)
    {

    }

    public function persist(mixed $entity): void
    {
        $this->entityManager->persist($entity);
    }

    public function flush(): void
    {
        $this->entityManager->flush();
    }

    public function remove(mixed $item): void
    {
        $this->entityManager->remove($item);
    }
}