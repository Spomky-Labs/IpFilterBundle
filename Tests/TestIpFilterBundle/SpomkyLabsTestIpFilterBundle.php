<?php

namespace SpomkyLabs\TestIpFilterBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use SpomkyLabs\TestIpFilterBundle\DependencyInjection\SpomkyTestExtension;

class SpomkyLabsTestIpFilterBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new SpomkyTestExtension('spomky_test');
    }
}
