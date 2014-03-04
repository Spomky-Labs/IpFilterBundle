<?php

namespace Spomky\IpFilterBundle\Tests\Functional\TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ip
 *
 * @ORM\Entity(repositoryClass="Spomky\IpFilterBundle\Model\IpRepository")
 */
class FakeIp2
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
}