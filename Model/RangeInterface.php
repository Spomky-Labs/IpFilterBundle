<?php

namespace Spomky\IpFilterBundle\Model;

interface RangeInterface
{
    public function getStartIp();
    public function getEndIp();
}
