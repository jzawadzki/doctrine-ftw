<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * VOrderRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class VOrderRepository extends EntityRepository
{
    public function getOrdersSumByYearBrand()
    {
        return $this->getEntityManager()->createQuery(
            "SELECT SUBSTRING(o.date, 1, 4) as year, sum(o.value) as orders_sum
            FROM AppBundle:VOrder o
            LEFT JOIN o.brand b
            GROUP BY year, b.id
            ORDER BY year"
        )
        ->getArrayResult();
    }
}
