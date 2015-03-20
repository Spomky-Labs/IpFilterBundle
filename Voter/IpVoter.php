<?php
namespace SpomkyLabs\IpFilterBundle\Voter;

use Symfony\Component\HttpFoundation\RequestStack;
use SpomkyLabs\IpFilterBundle\Model\IpManagerInterface;
use SpomkyLabs\IpFilterBundle\Model\RangeManagerInterface;

class IpVoter extends BaseIpVoter
{
    protected $environment;
    protected $request_stack;
    protected $im;
    protected $rm;

    public function __construct($environment, RequestStack $request_stack, IpManagerInterface $im, RangeManagerInterface $rm)
    {
        $this->environment   = $environment;
        $this->request_stack = $request_stack;
        $this->im            = $im;
        $this->rm            = $rm;
    }

    protected function getRequest()
    {
        return $this->request_stack->getCurrentRequest();
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
