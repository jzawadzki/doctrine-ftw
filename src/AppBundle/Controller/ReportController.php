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
        $orders = $this->getDoctrine()
                ->getManager()
                ->getRepository('AppBundle:VOrder')
                ->getAnnualTotalsByBrand();

        $brands = $this->getDoctrine()->getRepository('AppBundle:Brand')->findAll();
        $results = array();

        $brands_r = array();
        foreach($brands as $b) {
            $brands_r[$b->getId()] = 0;
        }

        foreach ($orders as $o) {
            if (!isset($results[$o['year']])) {
                $results[$o['year']] = array();
            }

            $results[$o['year']][$o['brand_id']] = $o['total'];
        }

        ksort($results);
        return $this->render('report/index.html.twig', array('brands' => $brands,'results' => $results));
    }

    /**
     * @Route("/app/customers/view/{id}", name="customers_view")
     */
    public function viewAction(Customer $customer)
    {
        return $this->render('customers/view.html.twig', array('customer' => $customer));
    }
}
