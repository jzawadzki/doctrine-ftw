<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Contact;
use AppBundle\Entity\Customer;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadCustomerData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 2000; $i++) {
            $customer = new Customer();
            $customer->setName('Customer #' . $i);
            $customer->setStatus(rand() % 2 ? 'active' : 'inactive');
            for ($j = 1; $j <= 5; $j++) {
                $contact = new Contact();
                $contact->setFirstName('John');
                $contact->setLastName('Doe ' . $i . '/' . $j);
                $contact->setEmail('john-' . $i . '-' . $j . '@example.org');
                $customer->getContacts()->add($contact);
                $contact->setCustomer($customer);
                $manager->persist($contact);
            }
            $manager->persist($customer);
            if ($i%20 == 0) {
                $manager->flush();
            }
        }
    }

    public function getOrder()
    {
        return 1; // the order in which fixtures will be loaded
    }
}