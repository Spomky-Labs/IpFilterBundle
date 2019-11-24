<?php

/*
 * The MIT License (MIT)
 *
 * Copyright (c) 2014-2015 Spomky-Labs
 *
 * This software may be modified and distributed under the terms
 * of the MIT license.  See the LICENSE file for details.
 */

namespace SpomkyLabs\AppIpFilterBundle\Entity;

use SpomkyLabs\IpFilterBundle\Entity\Range as Base;

class Range extends Base
{
    protected $id;

    public function getId()
    {
        return $this->id;
    }
}
