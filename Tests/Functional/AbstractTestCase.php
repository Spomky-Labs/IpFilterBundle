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

    /**
     * @var \Symfony\Bundle\FrameworkBundle\Console\Application
     */
    protected static $application;


    public function __construct($name = null, array $data = array(), $dataName = '')
    {
        //$fs = new Filesystem();
        //$fs->remove(sys_get_temp_dir().'/SpomkyTestBundle');

        parent::__construct($name, $data, $dataName);

        if (!static::$kernel) {
            static::$kernel = self::createKernel(array(
                'environment' => $this->environment,
                'debug'       => $this->debug
            ));
            static::$kernel->boot();
        }

        $this->container = static::$kernel->getContainer();

        self::runCommand('doctrine:database:create');
        self::runCommand('doctrine:schema:update --force');
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

    protected static function runCommand($command)
    {
        $command = sprintf('%s --quiet --no-interaction', $command);

        return self::getApplication()->run(new StringInput($command));
    }

    protected static function getApplication()
    {
        if (null === self::$application) {
            $client = static::createClient();

            self::$application = new Application($client->getKernel());
            self::$application->setAutoExit(false);
        }

        return self::$application;
    }
}
