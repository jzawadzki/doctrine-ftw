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
        $report = $this->getDoctrine()->getRepository('AppBundle:Brand')->findAllForIndex();

        $results = $brands = Array();

        foreach ($report as $row) {
            $results[$row['year']][$row['brand']['id']] = $row['total'];
            $brands[$row['brand']['id']] = $row['brand']['name'];
        }

        return $this->render('report/index.html.twig', Array(
            'brands' => $brands,
            'results' => $results
        ));
    }

    /**
     * @Route("/app/customers/view/{id}", name="customers_view")
     */
    public function viewAction(Customer $customer)
    {
        return $this->render('customers/view.html.twig', Array('customer' => $customer));
    }
}
