<?php

namespace Spomky\IpFilterBundle\Model;

class Ip implements RoleInterface
{
    protected $ip;
    protected $authorized;

    public function getIp() {
        return $this->ip;
    }

    public function isAuthorized() {
        return $this->authorized;
    }
}
