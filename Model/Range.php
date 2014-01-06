<?php

namespace Spomky\IpFilterBundle\Model;

class Range implements RangeInterface
{
    protected $start_ip;
    protected $end_ip;
    protected $environment;
    protected $authorized;

    public function getStartIp()
    {
        return $this->start_ip;
    }

    public function getEndIp()
    {
        return $this->Range;
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