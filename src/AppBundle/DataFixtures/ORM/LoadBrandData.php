<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Brand;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadBrandData  extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        for($i=1;$i<=100;$i++) {
            $brand = new Brand();
            $brand->setName('Brand #'.$i);

            $manager->persist($brand);
            if ($i%20 == 0) {
                $manager->flush();
            }
        }
    }

    public function getOrder()
    {
        return 2; // the order in which fixtures will be loaded
    }
} 