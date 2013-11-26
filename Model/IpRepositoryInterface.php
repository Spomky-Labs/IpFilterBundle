<?php

namespace Spomky\IpFilterBundle\Model;

interface IpRepositoryInterface
{
    public function findByIp($ip, $environment);
}
