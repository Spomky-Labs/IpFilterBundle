<?php

namespace Spomky\IpFilterBundle\Model;

interface RangeInterface
{
    /**
     * @return string
     */
    public function getStartIp();

    /**
     * @return string
     */
    public function getEndIp();

    /**
     * @return string
     */
    public function getEnvironment();

    /**
     * @return boolean
     */
    public function isAuthorized();
}
