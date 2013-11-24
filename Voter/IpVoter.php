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

    public function __construct(Kernel $kernel, ContainerInterface $container, IpManagerInterface $im, RangeManagerInterface $rm) {

        $this->kernel = $kernel;
        $this->container = $container;
        $this->im        = $im;
        $this->rm        = $rm;
        $this->policy    = $container->getParameter('spomky_ip_filter.policy');
    }

    public function supportsAttribute($attribute) {

        return true;
    }

    public function supportsClass($class) {

        return true;
    }

    public function vote(TokenInterface $token, $object, array $attributes) {
        
        $client = $this->container->get('request')->getClientIp();
        $env = $this->kernel->getEnvironment();
        $ip = $this->im->findIp( $client, $env );
        $range = $this->rm->findByIp( $client, $env );
        if( $this->policy === 'whitelist' ) {
            return $ip||$range?VoterInterface::ACCESS_GRANTED:VoterInterface::ACCESS_DENIED;
        }
        if( $this->policy === 'blacklist' ) {
            return $ip||$range?VoterInterface::ACCESS_DENIED:VoterInterface::ACCESS_ABSTAIN;
        }
        return VoterInterface::ACCESS_ABSTAIN;
    }
}
