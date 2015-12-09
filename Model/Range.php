<?php

/*
 * The MIT License (MIT)
 *
 * Copyright (c) 2014-2015 Spomky-Labs
 *
 * This software may be modified and distributed under the terms
 * of the MIT license.  See the LICENSE file for details.
 */

namespace SpomkyLabs\IpFilterBundle\Model;

use SpomkyLabs\IpFilterBundle\Tool\IpConverter;

class Range implements RangeInterface
{
    protected $start_ip;
    protected $end_ip;
    protected $environment = [];
    protected $authorized;

    public function getStartIp()
    {
        return IpConverter::fromHexToIp($this->start_ip);
    }

    public function setStartIp($start_ip)
    {
        $this->start_ip = IpConverter::fromIpToHex($start_ip);

        return $this;
    }

    public function getEndIp()
    {
        return IpConverter::fromHexToIp($this->end_ip);
    }

    public function setEndIp($end_ip)
    {
        $this->end_ip = IpConverter::fromIpToHex($end_ip);

        return $this;
    }

    public function getEnvironment()
    {
        return $this->environment;
    }

    public function setEnvironment(array $environment)
    {
        $this->environment = $environment;

        return $this;
    }

    public function isAuthorized()
    {
        return $this->authorized;
    }

    public function setAuthorized($authorized)
    {
        $this->authorized = $authorized;

        return $this;
    }
}
