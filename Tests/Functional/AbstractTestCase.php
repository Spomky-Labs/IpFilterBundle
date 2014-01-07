<?php

namespace Spomky\IpFilterBundle\Tests\Functional;

use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\StringInput;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Filesystem\Filesystem;


abstract class AbstractTestCase extends WebTestCase
{
    /**
     * @var \Symfony\Component\DependencyInjection\Container
     */
    protected $container;

    /**
     * @var string
     */
    protected $environment = 'test';

    /**
     * @var bool
     */
    protected $debug = true;


    public function __construct($name = null, array $data = array(), $dataName = '')
    {

        parent::__construct($name, $data, $dataName);

        if (!static::$kernel) {
            static::$kernel = self::createKernel(array(
                'environment' => $this->environment,
                'debug'       => $this->debug
            ));
            static::$kernel->boot();
        }

        $this->container = static::$kernel->getContainer();
    }

    protected static function createKernel(array $options = array())
    {
        $env = @$options['environment'] ?: 'test';
        $debug = @$options['debug'] ?: 'true';

        return new AppKernel($env, $debug);
    }

    protected function tearDown()
    {
        static::$kernel = null;
        parent::tearDown();
    }
}
