<?php

namespace SpomkyLabs\TestIpFilterBundle;

use Generator;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class RequestTest
 *
 * @package SpomkyLabs\TestIpFilterBundle
 * @author  Remy Lescallier <lescallier1@gmail.com>
 */
class RequestTest extends WebTestCase
{
    /**
     * @dataProvider requestTestList()
     *
     * @param string $clientIp
     * @param string $resultStatusCode
     */
    public function testRequest(string $clientIp, string $resultStatusCode)
    {
        $client = self::createClient([], ['REMOTE_ADDR' => $clientIp]);
        $client->followRedirects(true);

        $client->request('GET', '/');
        $this->assertEquals($resultStatusCode, $client->getResponse()->getStatusCode());
    }

    /**
     * @return Generator
     */
    public function requestTestList()
    {
        yield ['192.168.1.20', '401'];
        yield ['fe80::2:0', '200'];
        yield ['192.168.1.12', '200'];
        yield ['192.168.1.22', '200'];
        yield ['192.168.2.110', '401'];
    }
}
