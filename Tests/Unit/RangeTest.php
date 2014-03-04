<?php

namespace Spomky\IpFilterBundle\Tests\Unit;

use Spomky\IpFilterBundle\Tests\Unit\Stub\RangeStub;

class RangeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider dataRanges
     */
    public function testRanges($start_ip, $end_ip, $environment, $authorized)
    {
        $obj = new RangeStub();
        $obj->setStartIp($start_ip);
        $obj->setEndIp($end_ip);
        $obj->setEnvironment($environment);
        $obj->setAuthorized($authorized);

        $this->assertInstanceOf('\Spomky\IpFilterBundle\Model\RangeInterface', $obj);
        $this->assertInstanceOf('\Spomky\IpFilterBundle\Model\Range', $obj);

        $this->assertEquals($obj->getStartIp(), $start_ip);
        $this->assertEquals($obj->getEndIp(), $end_ip);
        $this->assertEquals($obj->getEnvironment(), $environment);
        $this->assertEquals($obj->isAuthorized(), $authorized);
    }

    /**
     * Dataprovider for testRanges().
     */
    public function dataRanges()
    {
        return array(
            array(
                'a',
                'b',
                'c',
                'd',
            ),
            array(
                '1',
                '2',
                '3',
                '4',
            ),
        );
    }
}
