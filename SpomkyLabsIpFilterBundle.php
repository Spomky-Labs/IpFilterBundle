<?php

namespace SpomkyLabs\IpFilterBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use SpomkyLabs\IpFilterBundle\DependencyInjection\SpomkyIpFilterExtension;

class SpomkyLabsIpFilterBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new SpomkyIpFilterExtension('sl_ip_filter');
    }
}
