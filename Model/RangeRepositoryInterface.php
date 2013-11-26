<?php

namespace Spomky\IpFilterBundle\Model;

interface RangeRepositoryInterface
{
    public function findByIp($ip, $environment);
}
