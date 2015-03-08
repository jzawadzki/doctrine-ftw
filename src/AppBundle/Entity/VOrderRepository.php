<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

class VOrderRepository extends EntityRepository
{

    public function getOrdersReport()
    {
        $orders = $this->getEntityManager()->getRepository('AppBundle:VOrder')->findAll();
        $brands = $this->getEntityManager()->getRepository('AppBundle:Brand')->findAll();

        $brands_r = Array();
        foreach($brands as $b) {
            $brands_r[$b->getId()]=0;
        }

        $results = Array();
        foreach ($orders as $o) {
            if (!isset($results[$o->getDate()->format("Y")])) {
                $results[$o->getDate()->format("Y")]['brands'] = $brands_r;
                $results[$o->getDate()->format("Y")]['total'] = 0;
            }
            $results[$o->getDate()->format("Y")]['brands'][$o->getBrand()->getId()]+=$o->getValue();
            $results[$o->getDate()->format("Y")]['total'] += $o->getValue();
        }
        ksort($results);

        return array(
            'brands' => $brands,
            'results' => $results,
        );
    }
}
