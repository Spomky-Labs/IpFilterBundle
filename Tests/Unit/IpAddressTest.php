<?php

namespace Spomky\IpFilterBundle\Tests\Unit;

use Spomky\IpFilterBundle\Tests\Unit\Stub\IpStub;

class IpAddressTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider dataIps
     */
    public function testIps($ip, $environment, $authorized)
    {
        $obj = new IpStub();
        $obj->setIp($ip);
        $obj->setEnvironment($environment);
        $obj->setAuthorized($authorized);

        $this->assertEquals($obj->getIp(), $ip);
        $this->assertEquals($obj->getEnvironment(), $environment);
        $this->assertEquals($obj->isAuthorized(), $authorized);
    }

    /**
     * Dataprovider for testIps().
     */
    public function dataIps()
    {
        return array(
            array(
                'a',
                'b',
                'c',
            ),
            array(
                '1',
                '2',
                '3',
            ),
        );
    }
}
