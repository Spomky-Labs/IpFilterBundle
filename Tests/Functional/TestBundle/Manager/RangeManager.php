<?php

namespace Spomky\IpFilterBundle\Tests\Functional\TestBundle\Manager;

use Spomky\IpFilterBundle\Model\RangeInterface;
use Spomky\IpFilterBundle\Model\RangeManager as BaseRangeManager;


class RangeManager extends BaseRangeManager
{
    public function create()
    {
        $class = $this->getRepository()->getClassName();
        return new $class;
    }

    public function save(RangeInterface $range)
    {
        $this->getRepository()->persist($range);
    }

    public function remove(RangeInterface $range)
    {
        $this->getRepository()->remove($range);
    }

    public function flush()
    {
        $this->getRepository()->flush();
    }
}
