<?php

namespace Spomky\IpFilterBundle\Tests\Functional\TestBundle\Entity;

use Spomky\IpFilterBundle\Tests\Functional\TestBundle\Entity\AbstractRange;
use Doctrine\ORM\Mapping as ORM;

/**
 * Range
 *
 * @ORM\Entity(repositoryClass="Spomky\IpFilterBundle\Model\RangeRepository")
 */
class Range extends AbstractRange
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
}
