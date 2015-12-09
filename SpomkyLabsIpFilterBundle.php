<?php

/*
 * The MIT License (MIT)
 *
 * Copyright (c) 2014-2015 Spomky-Labs
 *
 * This software may be modified and distributed under the terms
 * of the MIT license.  See the LICENSE file for details.
 */

namespace SpomkyLabs\IpFilterBundle;

use SpomkyLabs\IpFilterBundle\DependencyInjection\SpomkyIpFilterExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class SpomkyLabsIpFilterBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new SpomkyIpFilterExtension('sl_ip_filter');
    }
}
