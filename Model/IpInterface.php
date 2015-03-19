<?php

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
