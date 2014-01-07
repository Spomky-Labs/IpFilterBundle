<?php

namespace Spomky\IpFilterBundle\Model;

use Spomky\IpFilterBundle\Model\IpInterface;

class Ip implements IpInterface
{
    protected $ip;
    protected $environment;
    protected $authorized;

    public function getIp()
    {
        return $this->ip;
    }

    public function getEnvironment()
    {
        return $this->environment;
    }

    public function isAuthorized()
    {
        return $this->authorized;
    }
}
