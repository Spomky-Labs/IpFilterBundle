<?php

namespace SpomkyLabs\IpFilterBundle\Model;

interface IpManagerInterface
{
    /**
     * @param string $ip
     * @param string $environment
     *
     * @return null|\SpomkyLabs\IpFilterBundle\Model\Ip[]
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
