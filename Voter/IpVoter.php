<?php
namespace Spomky\IpFilterBundle\Voter;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

use Symfony\Component\HttpKernel\Kernel;

use Spomky\IpFilterBundle\Model\IpManagerInterface;
use Spomky\IpFilterBundle\Model\RangeManagerInterface;

class IpVoter implements VoterInterface
{
    protected $kernel;
    protected $container;
    protected $im;
    protected $rm;
    protected $policy;

    public function __construct(Kernel $kernel, ContainerInterface $container, IpManagerInterface $im, RangeManagerInterface $rm)
    {
        $this->kernel    = $kernel;
        $this->container = $container;
        $this->im        = $im;
        $this->rm        = $rm;
    }

    public function supportsAttribute($attribute)
    {
        return true;
    }

    public function supportsClass($class)
    {
        return true;
    }

    public function vote(TokenInterface $token, $object, array $attributes)
    {
        $client = $this->container->get('request')->getClientIp();
        $env = $this->kernel->getEnvironment();

        $ips = $this->im->findIp( $client, $env );
        $ranges = $this->rm->findByIp( $client, $env );

        if ( count($ips) === 0 && count($ranges) === 0 ) {
            return VoterInterface::ACCESS_ABSTAIN;
        }

        foreach ($ips as $ip) {
            if ( $ip->isAuthorized() ) {
                return VoterInterface::ACCESS_GRANTED;
            }
        }

        foreach ($ranges as $range) {
            if ( $range->isAuthorized() ) {
                return VoterInterface::ACCESS_GRANTED;
            }
        }

        return VoterInterface::ACCESS_DENIED;
    }
}
