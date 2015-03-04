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
        $brands = $this->getDoctrine()->getRepository('AppBundle:Brand')->findAll();

        $rows = array();
        foreach ($brands as $brand) {
            $row = array();
            $row['brand'] = $brand;
            $row['customer'] = $this->getDoctrine()
                    ->getRepository('AppBundle:Customer')
                    ->getMostProfitableCustomerByBrand($brand);

            $rows[] = $row;
        }
        return $this->render('brands/index.html.twig', array('rows' => $rows));
    }


}
