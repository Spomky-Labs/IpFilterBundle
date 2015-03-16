<?php

namespace Spomky\IpFilterBundle\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Console\Application;

class WrongIpEntities2Test extends AbstractTestCase
{
    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
        static::$environment = 'test3';

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

    public function testAccess()
    {
        $client = static::createClient();

        try {
            $client->request(
                'GET',
                '/',
                array(),
                array(),
                array(
                    'REMOTE_ADDR' => '127.0.0.1',
                )
            );
            $this->fail('The expected exception was not thrown');
        } catch (\Exception $e) {
            $this->assertEquals('The Ip class \Spomky\IpFilterBundle\Tests\Functional\TestBundle\Entity\FakeIp2 must implement Spomky\IpFilterBundle\Model\IpInterface', $e->getMessage());
        }
    }
}
