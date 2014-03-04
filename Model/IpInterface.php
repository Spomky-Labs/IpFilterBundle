<?php

namespace Spomky\IpFilterBundle\Model;

interface IpInterface
{
    /**
     * @return string
     */
    public function getIp();

    /**
     * @return string
     */
    public function getEnvironment();

    /**
     * @return boolean
     */
    public function isAuthorized();
}
