<?php

namespace Spomky\IpFilterBundle\Tests\Functional\TestBundle\Entity;

use Spomky\IpFilterBundle\Model\Range as BaseRange;
use Doctrine\ORM\Mapping as ORM;

/**
 * Range
 *
 * @ORM\Entity()
 */
class FakeRange1 extends BaseRange
{
    /**
     * @var integer $id
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string $ip
     *
     * @ORM\Column(type="ipaddress")
     */
    protected $start_ip;

    /**
     * @var string $ip
     *
     * @ORM\Column(type="ipaddress")
     */
    protected $end_ip;

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

    public function setStartIp($start_ip) {
        $this->start_ip = $start_ip;
        return $this;
    }

    public function setEndIp($end_ip) {
        $this->end_ip = $end_ip;
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
