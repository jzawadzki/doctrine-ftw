<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Customer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ReportController extends Controller
{
    /**
     * @Route("/app/report", name="report_index")
     */
    public function indexAction()
    {
        $orders = $this->getDoctrine()->getManager()->createQuery('SELECT SUBSTRING(o.date, 1, 4) as year, b.id as brand_id, b.name as brand_name, sum(o.value) as value FROM AppBundle:VOrder o JOIN o.brand b GROUP BY year, brand_id ORDER BY year, brand_id')
           ->getResult();

        $brands = $this->getDoctrine()->getRepository('AppBundle:Brand')->findAll();
        $results = Array();

        $brands_r=Array();
        foreach($brands as $b)
            $brands_r[$b->getId()]=0;

        foreach ($orders as $o) {
            if (!isset($results[$o['year']]))
                $results[$o['year']] = $brands_r;

            $results[$o['year']][$o['brand_id']] = $o['value'];
        }
        ksort($results);
        return $this->render('report/index.html.twig', Array('brands'=>$brands,'results' => $results));
    }

    /**
     * @Route("/app/customers/view/{id}", name="customers_view")
     */
    public function viewAction(Customer $customer)
    {
        return $this->render('customers/view.html.twig', Array('customer' => $customer));
    }
}
