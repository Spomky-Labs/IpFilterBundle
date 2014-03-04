<?php

namespace Spomky\IpFilterBundle\Tests\Unit;

use Spomky\IpFilterBundle\DependencyInjection\SpomkyIpFilterExtension;

class ExtensionTest extends \PHPUnit_Framework_TestCase
{
    public function testExtension()
    {
        $extension = new SpomkyIpFilterExtension('alias');

        $this->assertEquals($extension->getAlias(), 'alias');
    }
}
