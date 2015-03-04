<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

class VOrderRepository extends EntityRepository
{
    public function getAnnualTotalsByBrand()
    {
        return $this->getEntityManager()
                ->createQuery('
                    SELECT SUBSTRING(o.date, 1, 4) AS year, b.id AS brand_id, SUM(o.value) AS total
                        FROM AppBundle:VOrder o
                            JOIN o.brand b
                        GROUP BY year, brand_id
                        ORDER BY year, brand_id
                ')->getResult();
    }
}
