<?php

namespace Spomky\IpFilterBundle\Tests\Functional\TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ip.
 *
 * @ORM\Entity()
 */
class FakeIp1 extends AbstractIp
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="ipaddress")
     */
    protected $ip;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    protected $environment;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean")
     */
    protected $authorized;
}
