<?php

namespace AppBundle\Entity\Repository;

use AppBundle\Entity\Customer;
use Doctrine\ORM\EntityRepository;

/**
 * Class CustomerRepository
 */
class CustomerRepository extends EntityRepository
{
    public function markAllOrdersComplete(Customer $customer)
    {
        $query = $this->_em->createQuery("UPDATE AppBundle:VOrder o SET o.status = 'completed' WHERE o.customer = :customer");
        $query->setParameter('customer', $customer);

        return $query->getResult();
    }
}