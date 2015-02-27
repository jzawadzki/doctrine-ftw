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
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            "SELECT SUBSTRING(o.date, 1, 4) AS year, SUM(o.value) AS total, b.name
             FROM AppBundle:Brand b
             LEFT JOIN AppBundle:VOrder o WITH o.brand = b.id
             GROUP BY year, b.id" 
        );
        
        $totalOrders= $query->getResult();
        
        $x = 0;
        $years = [];
        foreach ($totalOrders as $item) {
          $brandsAndValues[ $item['name'] ][] = $item['total'];
          
        if ( ! $years[$x - 1] != $item['year']) {
           $years[$x] = $item['year'];           
        }

          
          $x++;
        }        

        dump($years);        
    
        
//        $orders = $this->getDoctrine()->getRepository('AppBundle:VOrder')->findAll();
//
//        $brands = $this->getDoctrine()->getRepository('AppBundle:Brand')->findAll();
//        $results = Array();
//
//        $brands_r=Array();
//        foreach($brands as $b)
//            $brands_r[$b->getId()]=0;
//
//        foreach ($orders as $o) {
//            if (!isset($results[$o->getDate()->format("Y")]))
//                $results[$o->getDate()->format("Y")] = $brands_r;
//
//            $results[$o->getDate()->format("Y")][$o->getBrand()->getId()]+=$o->getValue();
//        }
//        ksort($results);
//        return $this->render('report/index.html.twig', Array('brands'=>$brands,'results' => $results));        
        
        return $this->render('report/index.html.twig', Array('brandsAndValues' => $brandsAndValues, 'years' => $years));
        
    }

    /**
     * @Route("/app/customers/view/{id}", name="customers_view")
     */
    public function viewAction(Customer $customer)
    {
        return $this->render('customers/view.html.twig', Array('customer' => $customer));
    }
}
