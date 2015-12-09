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

interface IpManagerInterface
{
    /**
     * @param string $ip
     * @param string $environment
     *
     * @return \SpomkyLabs\IpFilterBundle\Model\Ip[]
     */
    public function findIpAddress($ip, $environment);

    /**
     * @return \SpomkyLabs\IpFilterBundle\Model\IpInterface
     */
    public function createIp();

    /**
     * @param \SpomkyLabs\IpFilterBundle\Model\IpInterface $ip
     *
     * @return self
     */
    public function saveIp(IpInterface $ip);

    /**
     * @param \SpomkyLabs\IpFilterBundle\Model\IpInterface $ip
     *
     * @return self
     */
    public function deleteIp(IpInterface $ip);
}
