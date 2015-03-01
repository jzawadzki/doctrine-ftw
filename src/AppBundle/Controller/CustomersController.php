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
        $customers = $this->getDoctrine()->getManager()->createQuery('SELECT c, count(o) as orders_count FROM AppBundle:Customer c JOIN c.orders o GROUP BY c.id')
           ->getResult();

        $contacts = $this->getDoctrine()->getManager()->createQuery('SELECT c.id, MIN(con.email) as email FROM AppBundle:Customer c INDEX BY c.id LEFT JOIN c.contacts con GROUP BY c.id')
           ->getResult();

        return $this->render('customers/index.html.twig',Array('customers'=>$customers, 'contacts'=>$contacts));
    }

    /**
     * @Route("/app/customers/view/{id}", name="customers_view")
     */
    public function viewAction(Customer $customer) {
        return $this->render('customers/view.html.twig',Array('customer'=>$customer));
    }

    /**
     * @Route("/app/customers/view/{id}/markOrders", name="customers_update")
     * @Method({"POST"})
     */
    public function markOrdersAction(Customer $customer) {
        foreach($customer->getOrders() as $order)
            $order->setStatus('completed');
        $this->getDoctrine()->getManager()->flush();
        return $this->redirect($this->generateUrl('customers_index'));
    }
}
