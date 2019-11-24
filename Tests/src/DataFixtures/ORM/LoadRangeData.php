<?php

/*
 * The MIT License (MIT)
 *
 * Copyright (c) 2014-2015 Spomky-Labs
 *
 * This software may be modified and distributed under the terms
 * of the MIT license.  See the LICENSE file for details.
 */

namespace SpomkyLabs\AppIpFilterBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadRangeData extends AbstractFixture implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
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
//        $range_manager = $this->container->get('sl_ip_filter.range_manager');
        $range_manager = $this->container->get('sl_ip_filter.range_manager.default');

        foreach ($this->getRanges() as $ranges) {
            $range = $range_manager->createRange();
            $range->setStartIp($ranges['start_ip'])
                  ->setEndIp($ranges['end_ip'])
                  ->setAuthorized($ranges['authorized'])
                  ->setEnvironment($ranges['environment']);

            $range_manager->saveRange($range);
        }
    }

    protected function getRanges()
    {
        return [
            [
                'start_ip'    => '192.168.2.1',
                'end_ip'      => '192.168.2.100',
                'environment' => [],
                'authorized'  => true,
            ],
            [
                'start_ip'    => '192.168.2.101',
                'end_ip'      => '192.168.2.200',
                'environment' => [],
                'authorized'  => false,
            ],
            [
                'start_ip'    => '192.168.2.120',
                'end_ip'      => '192.168.2.121',
                'environment' => ['test', 'prod', 'dev'],
                'authorized'  => true,
            ],
            [
                'start_ip'    => 'fe80::0',
                'end_ip'      => 'fe80::ff',
                'environment' => ['test', 'prod', 'dev'],
                'authorized'  => false,
            ],
            [
                'start_ip'    => 'fe80::fa',
                'end_ip'      => 'fe80::fb',
                'environment' => ['test', 'prod', 'dev'],
                'authorized'  => true,
            ],
        ];
    }
}
