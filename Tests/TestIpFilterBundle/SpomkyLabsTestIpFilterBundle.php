<?php

/*
 * The MIT License (MIT)
 *
 * Copyright (c) 2014-2015 Spomky-Labs
 *
 * This software may be modified and distributed under the terms
 * of the MIT license.  See the LICENSE file for details.
 */

namespace SpomkyLabs\TestIpFilterBundle;

use SpomkyLabs\TestIpFilterBundle\DependencyInjection\SpomkyTestExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class SpomkyLabsTestIpFilterBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new SpomkyTestExtension('spomky_test');
    }
}
