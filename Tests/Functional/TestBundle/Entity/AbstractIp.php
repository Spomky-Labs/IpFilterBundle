<?php

namespace Spomky\IpFilterBundle\Tests\Functional\TestBundle\Entity;

use Spomky\IpFilterBundle\Model\Ip as BaseIp;

abstract class AbstractIp extends BaseIp
{
    protected $id;

    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $ip
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
        return $this;
    }

    /**
     * @param string $environment
     */
    public function setEnvironment($environment)
    {
        $this->environment = $environment;
        return $this;
    }

    /**
     * @param boolean $authorized
     */
    public function setAuthorized($authorized)
    {
        $this->authorized = $authorized;
        return $this;
    }
}