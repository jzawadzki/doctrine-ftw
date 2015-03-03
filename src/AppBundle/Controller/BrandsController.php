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
        $result = array();

        foreach ($brands as $brand) {
            $customer = $this->getDoctrine()->getRepository('AppBundle:Brand')
                ->findBestCustomer($brand);

            $result[] = array(
                'brand' => $brand,
                'customer' => $customer[0]->getCustomer()
            );
        }

        return $this->render('brands/index.html.twig',Array('brands'=>$result));
    }


}
