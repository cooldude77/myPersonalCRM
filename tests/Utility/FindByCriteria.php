<?php

namespace App\Tests\Utility;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

trait FindByCriteria
{

    public function findOneBy( string $entityName, array $criteria)
    {
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $repo = $em->getRepository($entityName);

        return $repo->findOneBy($criteria);


    }
}