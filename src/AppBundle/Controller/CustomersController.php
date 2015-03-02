<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Customer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CustomersController extends Controller
{
    /**
     * @Route("/app/customers", name="customers_index")
     */
    public function indexAction()
    {
        $customers = $this->getDoctrine()->getRepository('AppBundle:Customer')
            ->getCustomers();
        return $this->render('customers/index.html.twig', ['customers' => $customers, ]);
    }

    /**
     * @Route("/app/customers/view/{id}", name="customers_view")
     */
    public function viewAction(Customer $customer)
    {
        return $this->render('customers/view.html.twig', ['customer' => $customer]);
    }

    /**
     * @Route("/app/customers/view/{id}/markOrders", name="customers_update")
     * @Method({"POST"})
     */
    public function markOrdersAction(Customer $customer)
    {
        $this->getDoctrine()->getManager()
            ->getRepository('AppBundle:Customer')
            ->setAllOrdersAsComplete($customer);

        return $this->redirect($this->generateUrl('customers_index'));
    }
}
