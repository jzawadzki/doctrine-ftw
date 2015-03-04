<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Customer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BrandsController extends Controller
{
    /**
     * @Route("/app/brands", name="brands_index")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        $ordersQuery = $em->createQuery(
                "SELECT b.name AS brand, c.name, MAX(o.value) AS total
                FROM AppBundle:VOrder o
                LEFT JOIN o.brand b
                LEFT JOIN o.customer c
                GROUP BY b.id, c.id"
        );           
        
        $ordersData = $ordersQuery->getResult();  
        
        $results = array();

        foreach($ordersData as $order) {
            $brand = $order['brand'];
            $total = $order['total'];

            if(array_key_exists($brand, $results)) {
                if($results[$brand]['total'] < $total) {
                    $results[$brand] = $order;
                }
            } else {
                $results[$brand] = $order;
            }
        }                                  
        
        return $this->render('brands/index.html.twig',Array('results'=>$results));
    }

}
