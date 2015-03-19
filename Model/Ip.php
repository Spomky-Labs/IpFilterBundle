<?php

namespace SpomkyLabs\IpFilterBundle\Model;

use SpomkyLabs\IpFilterBundle\Tool\IpConverter;

class Ip implements IpInterface
{
    protected $ip;
    protected $environment = array();
    protected $authorized;

    public function getIp()
    {
        return IpConverter::fromHexToIp($this->ip);
    }

    public function setIp($ip)
    {
        $this->ip = IpConverter::fromIpToHex($ip);

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
}
