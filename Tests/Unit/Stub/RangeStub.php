<?php

namespace Spomky\IpFilterBundle\Tests\Unit\Stub;

use Spomky\IpFilterBundle\Model\Range;

class RangeStub extends Range
{
    public function setStartIp($start_ip)
    {
        $this->start_ip = $start_ip;

        return $this;
    }

    public function setEndIp($end_ip)
    {
        $this->end_ip = $end_ip;

        return $this;
    }

    public function setEnvironment($environment)
    {
        $this->environment = $environment;

        return $this;
    }

    public function setAuthorized($authorized)
    {
        $this->authorized = $authorized;

        return $this;
    }
}
