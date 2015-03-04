<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

class CustomerRepository extends EntityRepository
{
    public function findAllWithContacts()
    {
        return $this->getEntityManager()
                ->createQuery('
                    SELECT c.id, c.name, cc.email, SIZE(c.orders) AS ordersCount FROM AppBundle:Customer c JOIN c.contacts cc GROUP BY c.id
                ')->getResult();
    }
    
    public function getMostProfitableCustomerByBrand(Brand $brand)
    {
        return $this->getEntityManager()
                ->createQuery('
                    SELECT c, SUM(o.value) AS HIDDEN profit FROM AppBundle:Customer c JOIN c.orders o WHERE o.brand = :brand ORDER BY profit DESC
                ')
                ->setParameter('brand', $brand)
                ->getOneOrNullResult();
    }
}
