<?php

namespace Spomky\IpFilterBundle\Tests\Functional;

use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Filesystem\Filesystem;

use Spomky\IpFilterBundle\Tests\Functional\AppKernel;


abstract class AbstractTestCase extends WebTestCase
{
    /**
     * @var \Symfony\Bundle\FrameworkBundle\Console\Application
     */
    protected static $application;

    /**
     * @var string
     */
    protected static $environment;

    /**
     * @var bool
     */
    protected static $debug;

    protected static function createKernel(array $options = array())
    {
        if (null === static::$class) {
            static::$class = '\Spomky\IpFilterBundle\Tests\Functional\AppKernel';
        }

        return new AppKernel(
            isset($options['environment']) ? $options['environment'] : static::$environment,
            isset($options['debug']) ? $options['debug'] : static::$debug
        );
    }

    protected static function executeCommand($command, array $options = array()) {
        $options["--env"] = static::$environment;
        $options["--no-interaction"] = true;
        $options["--quiet"] = true;
        $options = array_merge($options, array('command' => $command));

        static::$application->run(new ArrayInput($options));
    }

    protected static function deleteDatabase() {
        $folder = __DIR__;
        foreach(array('/data.'.static::$environment.'.sqlite','/data.'.static::$environment.'.sqlite.bak') as $file){
            if(file_exists($folder . $file)) {
                unlink($folder . $file);
            }
        }
    }

    protected static function backupDatabase() {
        copy(__DIR__ . '/data.'.static::$environment.'.sqlite', __DIR__ . '/data.'.static::$environment.'.sqlite.bak');
    }

    protected static function restoreDatabase() {
        copy(__DIR__ . '/data.'.static::$environment.'.sqlite.bak', __DIR__ . '/data.'.static::$environment.'.sqlite');
    }
}
