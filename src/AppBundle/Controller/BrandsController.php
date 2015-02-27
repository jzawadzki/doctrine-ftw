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
                "SELECT b.name AS brand, c.name, SUM(o.value) AS total
                FROM AppBundle:VOrder o
                LEFT JOIN AppBundle:Brand b WITH b.id = o.brand
                LEFT JOIN AppBundle:Customer c WITH c.id = o.customer
                GROUP BY b.id"
        );           
        
        $namesQuery = $em->createQuery(
                "SELECT con.lastName, c.name
                FROM AppBundle:Customer c
                LEFT JOIN AppBundle:Contact con WITH c.id = con.customer
                GROUP BY con.id"
        );
        
        $ordersData = $ordersQuery->getResult();            
               
        return $this->render('brands/index.html.twig',Array('ordersData'=>$ordersData));
    }


}
