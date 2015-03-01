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
        $brands = $this->getDoctrine()->getRepository('AppBundle:Brand')->findAll();

        $results = [];
        foreach ($brands as $brand) {
            $array = [];
            $array[] = $brand;
            $array[] = $this->getDoctrine()->getRepository('AppBundle:Customer')->getBestCustomerForBrand($brand);

            $results[] = $array;
        }

        return $this->render('brands/index.html.twig', array('brands' => $results));
    }


}
