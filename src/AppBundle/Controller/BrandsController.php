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

        return $this->render('brands/index.html.twig',Array('brands'=>$brands));
    }


}
