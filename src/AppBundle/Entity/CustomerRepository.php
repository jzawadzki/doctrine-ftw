<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

class CustomerRepository extends EntityRepository
{
    public function findAllForIndex()
    {
        return $this->createQueryBuilder('c')
            ->select('PARTIAL c.{id, name} AS customer, PARTIAL co.{id, email}, COUNT(o.id) AS orderCount')
            ->leftJoin('c.contacts', 'co')
            ->leftJoin('c.orders', 'o')
            ->groupBy('c.id')
            ->getQuery()
            ->getArrayResult();
    }

    public function findBestCustomerName($brandId)
    {
        $result = $this->createQueryBuilder('c')
            ->select('c.name, SUM(o.value) as HIDDEN total')
            ->leftJoin('c.orders', 'o')
            ->innerJoin('o.brand', 'b')
            ->where('b.id = :brandId')->setParameter('brandId', $brandId)
            ->groupBy('c.id')
            ->orderBy('total', 'desc')
            ->setMaxResults(1)
            ->getQuery()
            ->getArrayResult();

        return $result[0]['name'];
    }
}