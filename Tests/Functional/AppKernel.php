<?php

namespace Spomky\IpFilterBundle\Tests\Functional;

use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            new \Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new \Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new \Spomky\IpFilterBundle\SpomkyIpFilterBundle(),

            new \Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new \Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle(),

            new \Spomky\IpFilterBundle\Tests\Functional\TestBundle\SpomkyTestBundle(),
        );

        return $bundles;
    }

    public function getCacheDir()
    {
        return sys_get_temp_dir().'/SpomkyTestBundle';
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config_'.$this->getEnvironment().'.yml');
    }
}
