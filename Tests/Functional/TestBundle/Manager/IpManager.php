<?php

namespace Spomky\IpFilterBundle\Tests\Functional\TestBundle\Manager;

use Spomky\IpFilterBundle\Model\IpInterface;
use Spomky\IpFilterBundle\Model\IpManager as BaseIpManager;

class IpManager extends BaseIpManager
{
    public function create()
    {
        $class = $this->getRepository()->getClassName();
        return new $class;
    }

    public function save(IpInterface $ip)
    {
        $this->getRepository()->persist($ip);
    }

    public function remove(IpInterface $ip)
    {
        $this->getRepository()->remove($ip);
    }

    public function flush()
    {
        $this->getRepository()->flush();
    }
}
