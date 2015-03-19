<?php

namespace SpomkyLabs\TestIpFilterBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class LoadRangeData extends AbstractFixture implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 5; // the order in which fixtures will be loaded
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $range_manager = $this->container->get('sl_ip_filter.range_manager');

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
        return array(
            array(
                'start_ip'    => '192.168.2.1',
                'end_ip'      => '192.168.2.100',
                'environment' => array(),
                'authorized'  => true,
            ),
            array(
                'start_ip'    => '192.168.2.101',
                'end_ip'      => '192.168.2.200',
                'environment' => array(),
                'authorized'  => false,
            ),
            array(
                'start_ip'    => '192.168.2.120',
                'end_ip'      => '192.168.2.121',
                'environment' => array('test','prod','dev'),
                'authorized'  => true,
            ),
            array(
                'start_ip'    => 'fe80::0',
                'end_ip'      => 'fe80::ff',
                'environment' => array('test','prod','dev'),
                'authorized'  => false,
            ),
            array(
                'start_ip'    => 'fe80::fa',
                'end_ip'      => 'fe80::fb',
                'environment' => array('test','prod','dev'),
                'authorized'  => true,
            ),
        );
    }
}
