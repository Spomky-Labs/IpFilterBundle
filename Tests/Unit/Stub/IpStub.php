<?php

namespace Spomky\IpFilterBundle\Tests\Unit\Stub;

use Spomky\IpFilterBundle\Model\Ip;

class IpStub extends Ip
{
    public function setIp($ip) {
        $this->ip = $ip;
        return $this;
    }

    public function setEnvironment($environment) {
        $this->environment = $environment;
        return $this;
        
    }

    public function setAuthorized($authorized) {
        $this->authorized = $authorized;
        return $this;

    }
}
