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

use SpomkyLabs\IpFilterBundle\Tool\IpConverter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;

abstract class BaseIpVoter implements VoterInterface
{
    /**
     * @return \Symfony\Component\HttpFoundation\Request
     */
    abstract protected function getRequest();

    /**
     * @return string
     */
    abstract protected function getEnvironment();

    /**
     * @return \SpomkyLabs\IpFilterBundle\Model\IpManagerInterface
     */
    abstract protected function getIpManager();

    /**
     * @return \SpomkyLabs\IpFilterBundle\Model\RangeManagerInterface
     */
    abstract protected function getRangeManager();

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
        $request = $this->getRequest();
        if (!$request) {
            throw new \Exception('No request found.');
        }

        $from = IpConverter::fromIpToHex($request->getClientIp());

        $env = $this->getEnvironment();

        $ips = $this->getIpManager()->findIpAddress($from, $env);
        $ranges = $this->getRangeManager()->findByIpAddress($from, $env);

        if (count($ips) === 0 && count($ranges) === 0) {
            return VoterInterface::ACCESS_ABSTAIN;
        }

        foreach ($ips as $ip) {
            if ($ip->isAuthorized()) {
                return VoterInterface::ACCESS_GRANTED;
            }
        }

        foreach ($ranges as $range) {
            if ($range->isAuthorized()) {
                return VoterInterface::ACCESS_GRANTED;
            }
        }

        return VoterInterface::ACCESS_DENIED;
    }
}
