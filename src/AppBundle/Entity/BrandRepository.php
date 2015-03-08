<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

class BrandRepository extends EntityRepository
{
    public function findAllWithCustomer()
    {
        $em = $this->getentityManager();

        // $brands = $em->getRepository('AppBundle:Brand')->findAll(Query::HYDRATE_ARRAY);
        $brands_raw = $em->createQuery('SELECT b from AppBundle:Brand b')->getArrayResult();

        $brands = array();
        foreach ($brands_raw as $brand) {
            $brands[$brand['id']] = $brand;
        }

        $orders = $em->createQuery(
            'SELECT identity(o.brand) as brand_id, SUM( o.value ) as total, c.name 
            FROM  AppBundle:VOrder o 
            LEFT JOIN o.customer c
            GROUP BY o.brand, o.customer
            ORDER BY o.brand, total DESC'
        )->getArrayResult();

        $prev_brand = 0;
        foreach ($orders as $order) {
            if ($order['brand_id'] != $prev_brand) {
                $brands[$order['brand_id']]['customer'] = $order['name'];
                $brands[$order['brand_id']]['customer_max_purchase'] = $order['total'];
            }
            $prev_brand = $order['brand_id'];
        }

        return $brands;
    }
}
