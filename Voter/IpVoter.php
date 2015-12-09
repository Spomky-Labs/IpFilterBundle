<?php

/*
 * The MIT License (MIT)
 *
 * Copyright (c) 2014-2015 Spomky-Labs
 *
 * This software may be modified and distributed under the terms
 * of the MIT license.  See the LICENSE file for details.
 */

namespace SpomkyLabs\IpFilterBundle\Voter;

use SpomkyLabs\IpFilterBundle\Model\IpManagerInterface;
use SpomkyLabs\IpFilterBundle\Model\RangeManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class IpVoter extends BaseIpVoter
{
    protected $environment;
    protected $request_stack;
    protected $im;
    protected $rm;

    public function __construct($environment, RequestStack $request_stack, IpManagerInterface $im, RangeManagerInterface $rm)
    {
        $this->environment = $environment;
        $this->request_stack = $request_stack;
        $this->im = $im;
        $this->rm = $rm;
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
