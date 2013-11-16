<?php
namespace Spomky\IpFilterBundle\Voter;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Spomky\IpFilterBundle\Model\IpManagerInterface;

class IpVoter implements VoterInterface
{
    protected $container;
    protected $im;

    public function __construct(ContainerInterface $container, IpManagerInterface $im)
    {
        $this->container     = $container;
        $this->im = $im;
    }

    public function supportsAttribute($attribute)
    {
        return true;
    }

    public function supportsClass($class)
    {
        return true;
    }

    function vote(TokenInterface $token, $object, array $attributes)
    {
        $request = $this->container->get('request');
        $ip = $this->im->findIp( $request->getClientIp() );
        if( !$ip )
            return VoterInterface::ACCESS_ABSTAIN;
        return $ip->isAuthorized()?VoterInterface::ACCESS_GRANTED:VoterInterface::ACCESS_DENIED;
    }
}
