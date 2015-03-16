<?php

namespace Spomky\IpFilterBundle\Tests\Functional\TestBundle\Manager;

use Spomky\IpFilterBundle\Model\IpInterface;
use Spomky\IpFilterBundle\Model\IpManager as BaseIpManager;

class IpManager extends BaseIpManager
{
    public function create()
    {
        $class = $this->getRepository()->getClassName();

        return new $class();
    }

    public function save(IpInterface $ip)
    {
        $this->getManager()->persist($ip);
        $this->getManager()->flush();
    }

    public function remove(IpInterface $ip)
    {
        $this->getManager()->remove($ip);
    }
}
