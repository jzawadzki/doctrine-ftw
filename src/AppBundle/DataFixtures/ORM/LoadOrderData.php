<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\VOrder;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadOrderData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        for($i=1;$i<=100000;$i++) {
            $order = new VOrder();
            $order->setCustomer($manager->getReference('\AppBundle\Entity\Customer',rand(1,2000)));
            $order->setBrand($manager->getReference('\AppBundle\Entity\Brand',rand(1,100)));
            $order->setDate(new \DateTime(rand(2000,2015).'-'.rand(1,12).'-'.rand(1,31)));
            $order->setStatus(rand()%2?'pending':'completed');
            $order->setValue(number_format(rand(10000,20000000)/100,2));
            $manager->persist($order);
        }


        $manager->flush();
    }

    public function getOrder()
    {
        return 3; // the order in which fixtures will be loaded
    }
} 