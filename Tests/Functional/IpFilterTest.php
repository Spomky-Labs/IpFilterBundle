<?php

namespace Spomky\IpFilterBundle\Tests\Functional;

use Spomky\IpFilterBundle\Tests\Functional\AbstractTestCase;

use Symfony\Bundle\FrameworkBundle\Console\Application;

use Symfony\Component\Filesystem\Filesystem;

class IpFilterTest extends AbstractTestCase
{
    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
        static::$environment = 'test1';

        static::$kernel = self::createKernel();

        static::$application = new Application(static::$kernel);
        static::$application->setAutoExit(false);

        self::deleteDatabase();
        
        self::executeCommand('doctrine:database:create');
        self::executeCommand('doctrine:schema:create');

        self::executeCommand('doctrine:fixtures:load');

        self::backupDatabase();
    }

    protected function setUp()
    {
        parent::setUp();
        $this->restoreDatabase();
    }

    public function testServicesAndObjects() {

        $client = static::createClient();
        $container = $client->getContainer();
        $ip_manager = $container->get("spomky_ip_filter.ip_manager");
        $range_manager = $container->get("spomky_ip_filter.range_manager");

        $this->assertInstanceOf('Spomky\IpFilterBundle\Tests\Functional\TestBundle\Manager\IpManager', $ip_manager);
        $this->assertInstanceOf('Spomky\IpFilterBundle\Model\IpManager', $ip_manager);
        $this->assertInstanceOf('Spomky\IpFilterBundle\Model\IpManagerInterface', $ip_manager);

        $this->assertInstanceOf('Spomky\IpFilterBundle\Tests\Functional\TestBundle\Manager\RangeManager', $range_manager);
        $this->assertInstanceOf('Spomky\IpFilterBundle\Model\RangeManager', $range_manager);
        $this->assertInstanceOf('Spomky\IpFilterBundle\Model\RangeManagerInterface', $range_manager);

        $ip_class = $ip_manager->create();
        $range_class = $range_manager->create();

        $this->assertInstanceOf('Spomky\IpFilterBundle\Tests\Functional\TestBundle\Entity\Ip', $ip_class);
        $this->assertInstanceOf('Spomky\IpFilterBundle\Model\Ip', $ip_class);
        $this->assertInstanceOf('Spomky\IpFilterBundle\Model\IpInterface', $ip_class);

        $this->assertInstanceOf('Spomky\IpFilterBundle\Tests\Functional\TestBundle\Entity\Range', $range_class);
        $this->assertInstanceOf('Spomky\IpFilterBundle\Model\Range', $range_class);
        $this->assertInstanceOf('Spomky\IpFilterBundle\Model\RangeInterface', $range_class);
    }

    /**
     * @dataProvider getIPV4Access
     */
    public function testIPV4Access($from,$exception = null) {

        $this->logicAccess($from,$exception);
    }

    /**
     * @dataProvider getIPV6Access
     */
    public function testIPV6Access($from,$exception = null) {

        $this->logicAccess($from,$exception);
    }


    protected function logicAccess($from,$exception = null) {

        $client = static::createClient();

        try {
            $client->request(
                'GET',
                '/',
                array(),
                array(),
                array(
                    'REMOTE_ADDR' => $from,
                )
            );
            $this->assertEquals(200, $client->getResponse()->getStatusCode());
            $this->assertEquals('Hello world!', $client->getResponse()->getContent());

            if ($exception !== null) {
                $this->fail('The expected exception was not thrown');
            }
        } catch (\Exception $e) {
            if (!$exception || !($e instanceof $exception)) {
                throw $e;
            }

            //$this->assertEquals(403, $e->getMessage());
        }
    }

    public function getIPV4Access() {

        return array(
            array(
                '127.0.0.1',
            ),
            array(
                '192.168.1.1',
            ),
            array(
                '192.168.1.2',
                'Symfony\Component\Security\Core\Exception\InsufficientAuthenticationException',
            ),
            array(
                '192.168.1.3',
            ),
            array(
                '192.168.1.20',
                'Symfony\Component\Security\Core\Exception\InsufficientAuthenticationException',
            ),

            array(
                '192.168.2.1',
            ),
            array(
                '192.168.2.50',
            ),
            array(
                '192.168.2.101',
                'Symfony\Component\Security\Core\Exception\InsufficientAuthenticationException',
            ),
            array(
                '192.168.2.119',
                'Symfony\Component\Security\Core\Exception\InsufficientAuthenticationException',
            ),
            array(
                '192.168.2.120',
            ),
            array(
                '192.168.2.121',
            ),
            array(
                '192.168.2.122',
                'Symfony\Component\Security\Core\Exception\InsufficientAuthenticationException',
            ),
            array(
                '192.168.2.150',
                'Symfony\Component\Security\Core\Exception\InsufficientAuthenticationException',
            ),
            array(
                '192.168.2.200',
                'Symfony\Component\Security\Core\Exception\InsufficientAuthenticationException',
            ),
            array(
                '192.168.2.201',
            ),
        );
    }

    public function getIPV6Access() {

        return array(
            array(
                '::1',
            ),
            array(
                'fe80::2:0',
            ),
            array(
                'fe80::2:10',
                'Symfony\Component\Security\Core\Exception\InsufficientAuthenticationException',
            ),
            array(
                'fe80::2:11',
                'Symfony\Component\Security\Core\Exception\InsufficientAuthenticationException',
            ),
            array(
                'fe80::2:12',
            ),

            array(
                'fe80::0',
                'Symfony\Component\Security\Core\Exception\InsufficientAuthenticationException',
            ),
            array(
                'fe80::f9',
                'Symfony\Component\Security\Core\Exception\InsufficientAuthenticationException',
            ),
            array(
                'fe80::fa',
            ),
            array(
                'fe80::fb',
            ),
            array(
                'fe80::fc',
                'Symfony\Component\Security\Core\Exception\InsufficientAuthenticationException',
            ),
            array(
                'fe80::1:0',
            ),
        );
    }
}
