<?php

namespace SpomkyLabs\TestIpFilterBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class LoadIpData extends AbstractFixture implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
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
        return array(
            array(
                'ip'          => '192.168.1.1',
                'environment' => array(),
                'authorized'  => false,
            ),
            array(
                'ip'          => '192.168.1.1',
                'environment' => array('test','prod','dev'),
                'authorized'  => true,
            ),
            array(
                'ip'          => '192.168.1.2',
                'environment' => array(),
                'authorized'  => false,
            ),
            array(
                'ip'          => '192.168.1.20',
                'environment' => array('test','prod','dev'),
                'authorized'  => false,
            ),
            array(
                'ip'          => 'fe80::2:0',
                'environment' => array(),
                'authorized'  => false,
            ),
            array(
                'ip'          => 'fe80::2:0',
                'environment' => array('test','prod','dev'),
                'authorized'  => true,
            ),
            array(
                'ip'          => 'fe80::2:10',
                'environment' => array(),
                'authorized'  => false,
            ),
            array(
                'ip'          => 'fe80::2:11',
                'environment' => array('test','prod','dev'),
                'authorized'  => false,
            ),
        );
    }
}
