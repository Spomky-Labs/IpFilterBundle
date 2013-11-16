<?php

namespace Spomky\IpFilterBundle\Model;

interface RangeManagerInterface
{
    public function findByIp($ip);
}
