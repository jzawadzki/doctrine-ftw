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
        $orders = $this->getDoctrine()->getRepository('AppBundle:VOrder')->sumValue();
        $brands = $this->getDoctrine()->getRepository('AppBundle:Brand')->findAll();
        $results = Array();

        $brands_r=Array();
        foreach($brands as $b)
            $brands_r[$b->getId()]=0;

        foreach ($orders as $order) {
            $o = $order['vorder'];
            if (!isset($results[$o->getDate()->format("Y")]))
                $results[$o->getDate()->format("Y")] = $brands_r;

            $results[$o->getDate()->format("Y")][$o->getBrand()->getId()]=(float)$order['total'];
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
