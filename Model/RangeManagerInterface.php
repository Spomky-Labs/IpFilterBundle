<?php

namespace Spomky\IpFilterBundle\Model;

interface RangeManagerInterface
{
    /**
     * @param string $ip
     * @param string $environment
     */
    public function findByIp($ip, $environment);
}
