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
        $customers = $this->getDoctrine()->getManager()
            ->createQuery('SELECT c.id, c.name, ct.email, SIZE(c.orders) AS num_orders FROM AppBundle:Customer c LEFT JOIN c.contacts ct')
            ->getArrayResult();

        return $this->render('customers/index.html.twig', array('customers' => $customers));
    }

    /**
     * @Route("/app/customers/view/{id}", name="customers_view")
     */
    public function viewAction(Customer $customer)
    {
        return $this->render('customers/view.html.twig', array('customer' => $customer));
    }

    /**
     * @Route("/app/customers/view/{id}/markOrders", name="customers_update")
     * @Method({"POST"})
     */
    public function markOrdersAction(Customer $customer)
    {
        foreach ($customer->getOrders() as $order) {
            $order->setStatus('completed');
        }

        $this->getDoctrine()->getManager()->flush();

        return $this->redirect($this->generateUrl('customers_index'));
    }
}
