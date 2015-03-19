<?php

namespace SpomkyLabs\TestIpFilterBundle\Entity;

use SpomkyLabs\IpFilterBundle\Entity\Ip as Base;

class Ip extends Base
{
    protected $id;

    public function getId()
    {
        return $this->id;
    }
}
