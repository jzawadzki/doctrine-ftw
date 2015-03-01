<?php

namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class VOrderRepository
 */
class VOrderRepository extends EntityRepository
{
    public function getBrandByYearReport()
    {
        $query = $this->_em->createQuery("SELECT SUM(o.value) AS value, YEAR(o.date) AS year, IDENTITY(o.brand) AS brand FROM AppBundle:VOrder o GROUP BY year, brand");
        $rows = $query->getArrayResult();

        $results = [];
        foreach($rows as $row) {
            if (!isset($results[$row['year']][$row['brand']])){
                $results[$row['year']][$row['brand']] = 0;
            }

            $results[$row['year']][$row['brand']] += $row['value'];
        }

        return $results;
    }
}