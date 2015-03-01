<?php

namespace AppBundle\Entity\Repository;

use AppBundle\Entity\Brand;
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

    public function getBestCustomerForBrand(Brand $brand)
    {
        $query = $this->_em->createQuery("SELECT c, SUM(o.value) AS HIDDEN value FROM AppBundle:Customer c JOIN c.orders o WHERE o.brand = :brand ORDER BY value DESC");
        $query->setParameter('brand', $brand);

        return $query->getSingleResult();
    }
}