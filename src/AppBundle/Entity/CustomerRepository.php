<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

class CustomerRepository extends EntityRepository
{
    public function getAllCustomers()
    {
        return $this
            ->getEntitymanager()
            ->createQuery(
                'SELECT partial c.{id, name}, partial o.{id}, partial ct.{id, email} FROM AppBundle:Customer c ' .
                'LEFT JOIN c.orders o ' .
                'LEFT JOIN c.contacts ct'
            )
            ->getArrayResult();
    }
}
