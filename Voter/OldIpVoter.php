<?php
namespace SpomkyLabs\IpFilterBundle\Voter;

use Symfony\Component\DependencyInjection\ContainerInterface;
use SpomkyLabs\IpFilterBundle\Model\IpManagerInterface;
use SpomkyLabs\IpFilterBundle\Model\RangeManagerInterface;

class OldIpVoter extends BaseIpVoter
{
    protected $environment;
    protected $container;
    protected $im;
    protected $rm;

    public function __construct($environment, ContainerInterface $container, IpManagerInterface $im, RangeManagerInterface $rm)
    {
        $this->environment   = $environment;
        $this->container     = $container;
        $this->im            = $im;
        $this->rm            = $rm;
    }

    protected function getRequest()
    {
        return $this->container->get('request');
    }

    protected function getEnvironment()
    {
        return $this->environment;
    }

    protected function getIpManager()
    {
        return $this->im;
    }

    protected function getRangeManager()
    {
        return $this->rm;
    }
}
