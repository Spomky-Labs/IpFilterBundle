<?php
namespace Spomky\IpFilterBundle\Voter;

use Symfony\Component\HttpFoundation\RequestStack;

use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

use Symfony\Component\HttpKernel\Kernel;

use Spomky\IpFilterBundle\Model\IpManagerInterface;
use Spomky\IpFilterBundle\Model\RangeManagerInterface;

class IpVoter implements VoterInterface
{
    protected $kernel;
    protected $request_stack;
    protected $im;
    protected $rm;
    protected $policy;

    public function __construct(Kernel $kernel, RequestStack $request_stack, IpManagerInterface $im, RangeManagerInterface $rm)
    {
        $this->kernel        = $kernel;
        $this->request_stack = $request_stack;
        $this->im            = $im;
        $this->rm            = $rm;
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
        $request = $this->request_stack->getCurrentRequest();
        if( !$request ) {
            throw new \Exception('No request found.');
        }

        $env = $this->kernel->getEnvironment();

        $ips = $this->im->findIp( $request->getClientIp(), $env );
        $ranges = $this->rm->findByIp( $request->getClientIp(), $env );

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
