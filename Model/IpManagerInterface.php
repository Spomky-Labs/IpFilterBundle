<?php

namespace Spomky\IpFilterBundle\Model;

interface IpManagerInterface
{
    /**
     * @param string $ip
     * @param string $environment
     */
    public function findIp($ip, $environment);
}
