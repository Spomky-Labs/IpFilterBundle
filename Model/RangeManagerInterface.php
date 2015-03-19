<?php

namespace SpomkyLabs\IpFilterBundle\Model;

interface RangeManagerInterface
{
    /**
     * @param string $network The network with CIDR (e.g. 0.0.0.0/0, 192.168.0.0/24, fe80::/64)
     *
     * @return \SpomkyLabs\IpFilterBundle\Model\RangeInterface
     */
    public function createRangeFromNetwork($network);

    /**
     * @param string $ip
     * @param string $environment
     *
     * @return \SpomkyLabs\IpFilterBundle\Model\RangeInterface[]
     */
    public function findByIpAddress($ip, $environment);

    /**
     * @return \SpomkyLabs\IpFilterBundle\Model\RangeInterface
     */
    public function createRange();

    /**
     * @param \SpomkyLabs\IpFilterBundle\Model\RangeInterface $range
     *
     * @return self
     */
    public function saveRange(RangeInterface $range);

    /**
     * @param \SpomkyLabs\IpFilterBundle\Model\RangeInterface $range
     *
     * @return self
     */
    public function deleteRange(RangeInterface $range);
}
