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
        $customerRepo = $this->getDoctrine()->getRepository('AppBundle:Customer');
        $brands = $this->getDoctrine()->getRepository('AppBundle:Brand')->findAllNames();

        foreach ($brands as &$brand) {
            $brand['customer'] = $customerRepo->findBestCustomerName($brand['id']);
        }

        return $this->render('brands/index.html.twig', Array(
            'brands' => $brands
        ));
    }
}
