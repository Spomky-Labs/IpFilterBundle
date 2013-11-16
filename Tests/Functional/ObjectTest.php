<?php

namespace Spomky\IpFilterBundle\Tests\Functional;

use Spomky\IpFilterBundle\Tests\Functional\TestBundle\Entity\Ip;
use Spomky\IpFilterBundle\Tests\Functional\TestBundle\Entity\Range;

class ObjectTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider dataIP
     */
    public function testIP($ip_expected, $env_expected, $isauthorized_expected)
    {
        $ip = new Ip;

        $ip->setIp($ip_expected);
        $ip->setAuthorized($isauthorized_expected);
        $ip->setEnvironment($env_expected);

        $this->assertInstanceOf('\Spomky\IpFilterBundle\Model\IpInterface', $ip);
        $this->assertInstanceOf('\Spomky\IpFilterBundle\Model\Ip', $ip);

        $this->assertEquals($ip->getIp(), $ip_expected);
        $this->assertEquals($ip->isAuthorized(), $isauthorized_expected);
        $this->assertEquals($ip->getEnvironment(), $env_expected);
    }

    /**
     * Dataprovider for testIP().
     */
    public function dataIP()
    {
        return array(
            array(
                "192.168.0.1",
                "test,dev",
                true,
            ),
            array(
                "127.0.0.1",
                null,
                false,
            ),
        );
    }

    /**
     * @dataProvider dataRange
     */
    public function testRange($start_expected, $end_expected, $env_expected, $isauthorized_expected)
    {
        $range = new Range;

        $range->setStartIp($start_expected);
        $range->setEndIp($end_expected);
        $range->setAuthorized($isauthorized_expected);
        $range->setEnvironment($env_expected);

        $this->assertInstanceOf('\Spomky\IpFilterBundle\Model\RangeInterface', $range);
        $this->assertInstanceOf('\Spomky\IpFilterBundle\Model\Range', $range);

        $this->assertEquals($range->getStartIp(), $start_expected);
        $this->assertEquals($range->getEndIp(), $end_expected);
        $this->assertEquals($range->isAuthorized(), $isauthorized_expected);
        $this->assertEquals($range->getEnvironment(), $env_expected);
    }

    /**
     * Dataprovider for testRange().
     */
    public function dataRange()
    {
        return array(
            array(
                "192.168.0.1",
                "192.168.0.10",
                "test,dev",
                true,
            ),
            array(
                "82.15.16.17",
                "82.150.160.170",
                null,
                false,
            ),
        );
    }
}
