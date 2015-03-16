<?php

namespace Spomky\IpFilterBundle\Tests\Functional\TestBundle\Manager;

use Spomky\IpFilterBundle\Model\RangeInterface;
use Spomky\IpFilterBundle\Model\RangeManager as BaseRangeManager;

class RangeManager extends BaseRangeManager
{
    public function create()
    {
        $class = $this->getRepository()->getClassName();

        return new $class();
    }

    public function save(RangeInterface $range)
    {
        $this->getManager()->persist($range);
        $this->getManager()->flush();
    }

    public function remove(RangeInterface $range)
    {
        $this->getManager()->remove($range);
    }
}
