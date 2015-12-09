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

interface IpInterface
{
    /**
     * @return string
     */
    public function getIp();

    /**
     * @param string $ip The IP address
     *
     * @return self
     */
    public function setIp($ip);

    /**
     * @return array
     */
    public function getEnvironment();

    /**
     * @param array $environment The environment
     *
     * @return self
     */
    public function setEnvironment(array $environment);

    /**
     * @return bool
     */
    public function isAuthorized();

    /**
     * @param bool $authorized
     *
     * @return self
     */
    public function setAuthorized($authorized);
}
