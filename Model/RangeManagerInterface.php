<?php

namespace SpomkyLabs\IpFilterBundle\Model;

interface RangeManagerInterface
{
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
