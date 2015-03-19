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
    public function setEndIp($end_ip);

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

}
