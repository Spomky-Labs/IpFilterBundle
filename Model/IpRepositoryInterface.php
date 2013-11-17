<?php

namespace Spomky\IpFilterBundle\Model;

interface IpRepositoryInterface
{
    public function findOneByIp($ip);
}
