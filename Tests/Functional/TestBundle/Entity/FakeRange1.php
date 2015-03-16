<?php

namespace Spomky\IpFilterBundle\Tests\Functional\TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Range.
 *
 * @ORM\Entity()
 */
class FakeRange1 extends AbstractRange
{
    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="ipaddress")
     */
    protected $start_ip;

    /**
     * @var string
     *
     * @ORM\Column(type="ipaddress")
     */
    protected $end_ip;

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
