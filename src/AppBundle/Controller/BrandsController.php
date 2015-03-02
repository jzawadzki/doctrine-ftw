<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BrandsController extends Controller
{
    /**
     * @Route("/app/brands", name="brands_index")
     */
    public function indexAction()
    {
        $results    = [];
        $brands     = $this->getDoctrine()->getRepository('AppBundle:Brand')->findAll();
        $orders     = $this->getDoctrine()->getRepository('AppBundle:VOrder');

        if ($brands && count($brands) > 0) {
            foreach ($brands as $brand) {
                $results[] = [
                    'brand_name'    => $brand->getName(),
                    'customer_name' => $orders->getTopCustomerForBrand($brand),
                ];
            }
        }

        return $this->render('brands/index.html.twig', ['results' => $results, ]);
    }
}
