<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Brand;

/**
 * VOrderRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class VOrderRepository extends EntityRepository
{
    /**
     * @return array
     */
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

    /**
     * @return array
     */
    public function getTopCustomerForBrand(Brand $brand)
    {
        $result = $this->getEntityManager()->createQuery(
            "SELECT sum(o.value) as total_sum, c.name
            FROM AppBundle:VOrder o
            LEFT JOIN o.customer c
            WHERE o.brand = :brand
            ORDER BY total_sum desc"
        )
        ->setParameter('brand', $brand)
        ->setMaxResults(1)
        ->getArrayResult();

        return (isset($result[0]['name'])) ? $result[0]['name'] : '';
    }
}
