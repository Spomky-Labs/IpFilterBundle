<?php

namespace SpomkyLabs\IpFilterBundle\Model;

use SpomkyLabs\IpFilterBundle\Tool\IpConverter;
use SpomkyLabs\IpFilterBundle\Tool\Network;

class Range implements RangeInterface
{
    protected $start_ip;
    protected $end_ip;
    protected $environment = array();
    protected $authorized;

    public function getStartIp()
    {
        return IpConverter::fromHexToIp($this->start_ip);
    }

    public function setStartIp($start_ip)
    {
        $this->start_ip = IpConverter::fromIpToHex($start_ip);

        return $this;
    }

    public function getEndIp()
    {
        return IpConverter::fromHexToIp($this->end_ip);
    }

    public function setEndIp($end_ip)
    {
        $this->end_ip = IpConverter::fromIpToHex($end_ip);

        return $this;
    }

    public function getEnvironment()
    {
        return $this->environment;
    }

    public function setEnvironment(array $environment)
    {
        $this->environment = $environment;

        return $this;
    }

    public function isAuthorized()
    {
        return $this->authorized;
    }

    public function setAuthorized($authorized)
    {
        $this->authorized = $authorized;

        return $this;
    }

    public function setNetwork($network)
    {
        $range = Network::getRange($network);
        $this->setStartIp($range['start']);
        $this->setEndIp($range['end']);

        return $this;
    }
}
