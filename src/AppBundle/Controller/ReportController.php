<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ReportController extends Controller
{
    /**
     * @Route("/app/report", name="report_index")
     */
    public function indexAction()
    {
        $orders = $this->getDoctrine()->getManager()->getRepository('AppBundle:VOrder')
            ->getOrdersSumByYearBrand();

        $results    = $this->prepareForView($orders);
        $brands     = $this->getDoctrine()->getRepository('AppBundle:Brand')->findAll();

        return $this->render(
            'report/index.html.twig',
            ['brands' => $brands, 'results' => $results]
        );
    }

    protected function prepareForView(array $orders)
    {
        $results = [];

        if ($orders && count($orders) > 0) {
            foreach ($orders as $order) {
                $year               = (int) $order['year'];
                $results[$year][]   = $order['orders_sum'];
            }
        }

        return $results;
    }
}
