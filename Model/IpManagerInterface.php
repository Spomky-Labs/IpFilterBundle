<?php

namespace Spomky\IpFilterBundle\Model;

interface IpManagerInterface
{
    public function findIp($ip, $environment);
}
