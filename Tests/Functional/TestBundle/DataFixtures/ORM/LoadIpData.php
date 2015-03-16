<?php

namespace Spomky\IpFilterBundle\Tests\Functional\TestBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Spomky\IpFilterBundle\Tests\Functional\TestBundle\Entity\Ip;

class LoadIpData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        //IPV4
        $ip1 = new Ip();
        $ip1->setIp('192.168.1.1');
        $ip1->setAuthorized(false);

        $ip1_1 = new Ip();
        $ip1_1->setIp('192.168.1.1');
        $ip1_1->setAuthorized(true);
        $ip1_1->setEnvironment('test1,test2,test3');

        $ip2 = new Ip();
        $ip2->setIp('192.168.1.2');
        $ip2->setAuthorized(false);

        $ip3 = new Ip();
        $ip3->setIp('192.168.1.20');
        $ip3->setAuthorized(false);
        $ip3->setEnvironment('test1,test2,test3');

        //IPV6
        $ip4 = new Ip();
        $ip4->setIp('fe80::2:0');
        $ip4->setAuthorized(false);

        $ip5 = new Ip();
        $ip5->setIp('fe80::2:0');
        $ip5->setAuthorized(true);
        $ip5->setEnvironment('test1,test2,test3');

        $ip6 = new Ip();
        $ip6->setIp('fe80::2:10');
        $ip6->setAuthorized(false);

        $ip7 = new Ip();
        $ip7->setIp('fe80::2:11');
        $ip7->setAuthorized(false);
        $ip7->setEnvironment('test1,test2,test3');

        $manager->persist($ip1);
        $manager->persist($ip1_1);
        $manager->persist($ip2);
        $manager->persist($ip3);

        $manager->persist($ip4);
        $manager->persist($ip5);
        $manager->persist($ip6);
        $manager->persist($ip7);

        $manager->flush();
    }
}
