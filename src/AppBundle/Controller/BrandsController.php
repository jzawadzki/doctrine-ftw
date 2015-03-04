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
                "SELECT b.name AS brand, c.name, MAX(DISTINCT o.value) AS total
                FROM AppBundle:VOrder o
                LEFT JOIN o.brand b
                LEFT JOIN o.customer c
                GROUP BY b.id, c.id"
        );                  
        
        $ordersData = $ordersQuery->getResult();            
               
        return $this->render('brands/index.html.twig',Array('ordersData'=>$ordersData));
    }


}
