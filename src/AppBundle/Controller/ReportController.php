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
        $brands  = $this->getDoctrine()->getRepository('AppBundle:Brand')->findAll();
        $results = $this->getDoctrine()->getRepository('AppBundle:VOrder')->getBrandByYearReport();

        return $this->render('report/index.html.twig', array('brands' => $brands, 'results' => $results));
    }

    /**
     * @Route("/app/customers/view/{id}", name="customers_view")
     */
    public function viewAction(Customer $customer)
    {
        return $this->render('customers/view.html.twig', array('customer' => $customer));
    }
}
