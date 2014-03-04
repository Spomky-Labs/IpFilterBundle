<?php

namespace Spomky\IpFilterBundle\Tests\Functional\TestBundle\Entity;

use Spomky\IpFilterBundle\Model\Ip as BaseIp;
use Doctrine\ORM\Mapping as ORM;

/**
 * Ip
 *
 * @ORM\Entity()
 */
class FakeIp1 extends BaseIp
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string $ip
     *
     * @ORM\Column(type="ipaddress")
     */
    protected $ip;

    /**
     * @var string $environment
     *
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    protected $environment;

    /**
     * @var boolean $authorized
     *
     * @ORM\Column(type="boolean")
     */
    protected $authorized;

    public function getId() {
        return $this->id;
    }

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