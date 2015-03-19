<?php

namespace SpomkyLabs\IpFilterBundle\Model;

interface RangeInterface
{
    /**
     * @return string
     */
    public function getStartIp();
    /**
     * @param string $start_ip The start IP address
     *
     * @return self
     */
    public function setStartIp($start_ip);

    /**
     * @return string
     */
    public function getEndIp();

    /**
     * @param string $end_ip The end IP address
     *
     * @return self
     */
    public function setEndIp($end_ip0);

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
     * @return boolean
     */
    public function isAuthorized();

    /**
     * @param boolean $authorized
     *
     * @return self
     */
    public function setAuthorized($authorized);

    /**
     * @param string $network The network with CIDR (e.g. 0.0.0.0/0, 192.168.0.0/24, fe80::/64)
     *
     * @return self
     */
    public function setNetwork($network);

}
