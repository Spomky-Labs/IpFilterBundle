<?php

/*
 * The MIT License (MIT)
 *
 * Copyright (c) 2014-2015 Spomky-Labs
 *
 * This software may be modified and distributed under the terms
 * of the MIT license.  See the LICENSE file for details.
 */

namespace SpomkyLabs\TestIpFilterBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadIpData extends AbstractFixture implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritdoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 5; // the order in which fixtures will be loaded
    }

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $ip_manager = $this->container->get('sl_ip_filter.ip_manager');

        foreach ($this->getIps() as $ips) {
            $ip = $ip_manager->createIp();
            $ip->setIp($ips['ip'])
               ->setAuthorized($ips['authorized'])
               ->setEnvironment($ips['environment']);

            $ip_manager->saveIp($ip);
        }
    }

    protected function getIps()
    {
        return [
            [
                'ip'          => '192.168.1.1',
                'environment' => [],
                'authorized'  => false,
            ],
            [
                'ip'          => '192.168.1.1',
                'environment' => ['test', 'prod', 'dev'],
                'authorized'  => true,
            ],
            [
                'ip'          => '192.168.1.2',
                'environment' => [],
                'authorized'  => false,
            ],
            [
                'ip'          => '192.168.1.20',
                'environment' => ['test', 'prod', 'dev'],
                'authorized'  => false,
            ],
            [
                'ip'          => 'fe80::2:0',
                'environment' => [],
                'authorized'  => false,
            ],
            [
                'ip'          => 'fe80::2:0',
                'environment' => ['test', 'prod', 'dev'],
                'authorized'  => true,
            ],
            [
                'ip'          => 'fe80::2:10',
                'environment' => [],
                'authorized'  => false,
            ],
            [
                'ip'          => 'fe80::2:11',
                'environment' => ['test', 'prod', 'dev'],
                'authorized'  => false,
            ],
        ];
    }
}
