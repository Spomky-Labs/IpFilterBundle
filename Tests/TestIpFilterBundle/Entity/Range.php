<?php

namespace SpomkyLabs\TestIpFilterBundle\Entity;

use SpomkyLabs\IpFilterBundle\Entity\Range as Base;

class Range extends Base
{
    protected $id;

    public function getId()
    {
        return $this->id;
    }
}
