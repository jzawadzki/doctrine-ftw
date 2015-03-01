<?php

namespace AppBundle\Controller;

use Doctrine\ORM\Query\ResultSetMapping;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BrandsController extends Controller
{
    /**
     * @Route("/app/brands", name="brands_index")
     */
    public function indexAction()
    {
        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('brand_name', 'brand_name');
        $rsm->addScalarResult('customer_name', 'customer_name');
        $brands = $this->getDoctrine()->getManager()->createNativeQuery('
                SELECT
                    b.name AS brand_name, c.name AS customer_name
                FROM Brand b
                LEFT JOIN (
                    SELECT
                        brand_id, MAX(value) as value
                    FROM (
                        SELECT brand_id, customer_id, SUM(value) AS value
                        FROM VOrder
                        GROUP BY brand_id, customer_id
                    ) o1
                    GROUP BY brand_id
                ) bv ON (b.id = bv.brand_id)
                LEFT JOIN (
                    SELECT brand_id, customer_id, SUM(value) AS value
                    FROM VOrder
                    GROUP BY brand_id, customer_id
                ) o2 ON (bv.value = o2.value)
                LEFT JOIN Customer c ON (c.id = o2.customer_id)
                GROUP BY b.id;
            ', $rsm)
            ->getResult();

        return $this->render('brands/index.html.twig',Array('brands'=>$brands));
    }


}
