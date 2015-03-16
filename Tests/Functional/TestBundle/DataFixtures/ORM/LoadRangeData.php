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
        //IPV4
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
        $range2_1->setEnvironment('test1,test2,test3');

        //IPV6
        $range3 = new Range();
        $range3->setStartIp('fe80::0');
        $range3->setEndIp('fe80::ff');
        $range3->setAuthorized(false);
        $range3->setEnvironment('test1,test2,test3');

        $range4 = new Range();
        $range4->setStartIp('fe80::fa');
        $range4->setEndIp('fe80::fb');
        $range4->setAuthorized(true);
        $range4->setEnvironment('test1,test2,test3');

        $manager->persist($range1);
        $manager->persist($range2);
        $manager->persist($range2_1);
        $manager->persist($range3);
        $manager->persist($range4);

        $manager->flush();
    }
}
