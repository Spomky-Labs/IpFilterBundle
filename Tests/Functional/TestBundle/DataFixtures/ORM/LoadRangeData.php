<?php

namespace Spomky\IpFilterBundle\Tests\Functional\TestBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Spomky\IpFilterBundle\Tests\Functional\TestBundle\Entity\Range;

class LoadRangeData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $range1 = new Range();
        $range1->setStartIp('192.168.2.1');
        $range1->setEndIp('192.168.2.100');
        $range1->setAuthorized(true);

        $range2 = new Range();
        $range2->setStartIp('192.168.2.101');
        $range2->setEndIp('192.168.2.200');
        $range2->setAuthorized(false);

        $range2_1 = new Range();
        $range2_1->setStartIp('192.168.2.120');
        $range2_1->setEndIp('192.168.2.121');
        $range2_1->setAuthorized(true);
        $range2_1->setEnvironment('test');

        $manager->persist($range1);
        $manager->persist($range2);
        $manager->persist($range2_1);
        
        $manager->flush();
    }
}
