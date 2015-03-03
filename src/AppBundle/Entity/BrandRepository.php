<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

class BrandRepository extends EntityRepository
{
    public function findAllForIndex()
    {
        return $this->createQueryBuilder('b')
            ->select('SUBSTRING(o.date, 1, 4) as year, SUM(o.value) AS total, PARTIAL b.{id, name} as brand')
            ->leftJoin('b.orders', 'o')
            ->orderBy('year')->addOrderBy('b.id')
            ->groupBy('year')->addGroupBy('b.id')
            ->getQuery()
            ->getArrayResult();
    }

    public function findAllNames()
    {
        return $this->createQueryBuilder('b')
            ->select('b.id, b.name')
            ->getQuery()
            ->getArrayResult();
    }
}