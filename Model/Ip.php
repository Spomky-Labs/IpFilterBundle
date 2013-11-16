<?php

namespace Spomky\IpFilterBundle\Model;

class Ip implements IpInterface
{
    protected $ip;

    public function getIp() {
        return $this->ip;
    }
}
