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
            ->createQuery(
                'select c.id, c.name, co.email, size(c.orders) as orders '
                . 'from AppBundle:Customer c left join c.contacts co '
                . 'group by c.id'
            )
            ->getArrayResult();

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
