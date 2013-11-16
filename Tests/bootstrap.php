<?php

use Symfony\Bundle\FrameworkBundle\Console\Application;

require __DIR__ . '/TestHelper.php';

if (!is_file($autoloadFile = __DIR__.'/../vendor/autoload.php')) {
    throw new \LogicException('Could not find autoload.php in vendor/. Did you run "composer install --dev"?');
}

/**
 * @var ClassLoader $loader
 */
$loader = require $autoloadFile;
\Doctrine\Common\Annotations\AnnotationRegistry::registerLoader('class_exists');

require_once __DIR__ . '/Functional/AppKernel.php';


$kernel = new Spomky\IpFilterBundle\Tests\Functional\AppKernel('test', true);
$kernel->boot();

$application = new Application($kernel);
$application->setAutoExit(false);

TestHelper::deleteDatabase();

TestHelper::executeCommand($application, 'doctrine:database:create');
TestHelper::executeCommand($application, "doctrine:schema:create");

TestHelper::backupDatabase();

TestHelper::executeCommand($application, 'doctrine:fixtures:load');
