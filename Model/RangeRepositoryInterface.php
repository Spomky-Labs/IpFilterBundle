<?php

namespace Spomky\IpFilterBundle\Model;

interface RangeRepositoryInterface
{
    public function findOneByIp($ip);
}
