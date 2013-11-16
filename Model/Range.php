<?php

namespace Spomky\IpFilterBundle\Model;

class Range implements RangeInterface
{
    protected $start_ip;
    protected $end_ip;

    public function getStartIp() {
        return $this->start_ip;
    }

    public function getEndIp() {
        return $this->end_ip;
    }
}
