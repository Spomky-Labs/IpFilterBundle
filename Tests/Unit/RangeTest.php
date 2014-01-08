<?php

namespace Spomky\IpFilterBundle\Tests\Unit;

use Spomky\IpFilterBundle\Tool\Network;


class RangeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider dataRanges
     */
    public function testRanges($network, $begin_expected, $end_expected, $network_expected, $mask_expected, $broadcast_expected, $exception_message = null)
    {
        try {
            $result = Network::getRange($network);

            $this->assertEquals($begin_expected, $result['start']);
            $this->assertEquals($end_expected, $result['end']);

            if(isset($result['network'])) {
                $this->assertEquals($network_expected, $result['network']);
            }

            if(isset($result['broadcast'])) {
                $this->assertEquals($broadcast_expected, $result['broadcast']);
            }

            if(isset($result['mask'])) {
                $this->assertEquals($mask_expected, $result['mask']);
            }

            if ($exception_message !== null) {
                $this->fail('The expected exception was not thrown');
            }
        } catch (\Exception $e) {
            
            if(!$exception_message) {
                throw $e;
            }
            $this->assertEquals($exception_message, $e->getMessage());
        }
    }

    /**
     * Dataprovider for testRanges().
     */
    public function dataRanges()
    {
        return array(
            array(
                'hip hop',
                null,
                null,
                null,
                null,
                null,
                "Invalid IP/CIDR combination supplied"
            ),
            array(
                'hip/hop',
                null,
                null,
                null,
                null,
                null,
                "Invalid IP/CIDR combination supplied"
            ),

            array(
                '192.168.0.0/24',
                '192.168.0.1',
                '192.168.0.254',
                '192.168.0.0',
                '255.255.255.0',
                '192.168.0.255',
            ),
            array(
                '82.15.49.32/18',
                '82.15.0.1',
                '82.15.63.254',
                '82.15.0.0',
                '255.255.192.0',
                '82.15.63.255',
            ),
            array(
                '82.15.49.32/95',
                null,
                null,
                null,
                null,
                null,
                "Invalid network, IPv4 CIDR must be between 0 and 32."
            ),
            array(
                'fe80::10/64',
                'fe80::',
                'fe80::ffff:ffff:ffff:ffff',
                null,
                null,
                null,
            ),
            array(
                'fe80::10/129',
                null,
                null,
                null,
                null,
                null,
                "Invalid network, IPv6 CIDR must be between 0 and 128."
            ),
            array(
                'fec0::0000/10',
                'fec0::',
                'feff:ffff:ffff:ffff:ffff:ffff:ffff:ffff',
                null,
                null,
                null,
            ),
        );
    }
}
