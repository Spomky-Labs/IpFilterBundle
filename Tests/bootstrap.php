<?php

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;

function executeCommand($application, $command, array $options = array()) {
    $options["--env"] = "test";
    $options["--no-interaction"] = true;
    $options["--quiet"] = true;
    $options = array_merge($options, array('command' => $command));

    $application->run(new ArrayInput($options));
}

function deleteDatabase() {
    $folder = __DIR__;
    foreach(array('/Functional/data.sqlite','/Functional/data.sqlite.bak') as $file){
        if(file_exists($folder . $file)) {
            unlink($folder . $file);
        }
    }
}

function backupDatabase() {
    copy(__DIR__ . '/Functional/data.sqlite', __DIR__ . '/Functional/data.sqlite.bak');
}

function restoreDatabase() {
    copy(__DIR__ . '/Functional/data.sqlite.bak', __DIR__ . '/Functional/data.sqlite');
}


if (!is_file($autoloadFile = __DIR__.'/../vendor/autoload.php')) {
    throw new \LogicException('Could not find autoload.php in vendor/. Did you run "composer install --dev"?');
}

/**
 * @var ClassLoader $loader
 */
$loader = require $autoloadFile;
\Doctrine\Common\Annotations\AnnotationRegistry::registerLoader('class_exists');

require_once __DIR__ . '/Functional/AppKernel.php';


$kernel = new Spomky\IpFilterBundle\Tests\Functional\AppKernel('test', true); // create a "test" kernel
$kernel->boot();

$application = new Application($kernel);
$application->setAutoExit(false);

deleteDatabase();

executeCommand($application, 'doctrine:database:create');
executeCommand($application, "doctrine:schema:create");

backupDatabase();

//executeCommand($application, 'doctrine:schema:update', array('--force'=>true));
executeCommand($application, 'doctrine:fixtures:load');
