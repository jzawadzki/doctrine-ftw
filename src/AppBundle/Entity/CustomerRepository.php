<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Customer;

/**
 * CustomerRepository
 */
class CustomerRepository extends EntityRepository
{
    public function setAllOrdersAsComplete(Customer $customer)
    {
        return $this->getEntityManager()->createQuery(
            "UPDATE AppBundle:VOrder o SET o.status = 'completed' WHERE o.customer = :customer"
        )
        ->setParameter('customer', $customer)
        ->getResult();
    }

    /**
     * @return array
     */
    public function getCustomers()
    {
        return $this->getEntityManager()->createQuery(
            "SELECT c.id, c.name, co.email, size(c.orders) as orders
            FROM AppBundle:Customer c
            LEFT JOIN c.contacts co
            GROUP BY c.id"
        )
        ->getArrayResult();
    }
}
