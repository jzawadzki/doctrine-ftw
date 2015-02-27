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

        $years = [];
        foreach ($totalOrders as $item) {
          $brandsAndValues[ $item['name'] ][] = $item['total'];   
          if(!in_array($item['year'], $years)) {
              $years[] = $item['year'];
          }
        }        
    
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
