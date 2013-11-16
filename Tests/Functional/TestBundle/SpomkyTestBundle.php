<?php

namespace Spomky\IpFilterBundle\Tests\Functional\TestBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Spomky\IpFilterBundle\Tests\Functional\TestBundle\DependencyInjection\SpomkyTestExtension;

class SpomkyTestBundle extends Bundle
{

    public function getContainerExtension()
    {
        return new SpomkyTestExtension('spomky_test');
    }
}
