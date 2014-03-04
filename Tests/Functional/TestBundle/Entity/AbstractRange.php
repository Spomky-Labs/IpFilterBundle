<?php

namespace Spomky\IpFilterBundle\Tests\Functional\TestBundle\Entity;

use Spomky\IpFilterBundle\Model\Range as BaseRange;

class AbstractRange extends BaseRange
{
    protected $id;

    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $start_ip
     */
    public function setStartIp($start_ip)
    {
        $this->start_ip = $start_ip;
        return $this;
    }

    /**
     * @param string $end_ip
     */
    public function setEndIp($end_ip)
    {
        $this->end_ip = $end_ip;
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
