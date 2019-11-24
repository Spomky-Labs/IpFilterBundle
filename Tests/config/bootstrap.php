<?php

$_ENV['APP_ENV'] = isset($_ENV['APP_ENV']) ? $_ENV['APP_ENV'] : 'test';
$_ENV['TEST_GENERATE_DB'] = isset($_ENV['TEST_GENERATE_DB']) ? (bool) $_ENV['TEST_GENERATE_DB'] : true;
$_ENV['CLI_FROM_SYMFONY_CONSOLE'] = isset($_ENV['CLI_FROM_SYMFONY_CONSOLE']) ? (bool) $_ENV['CLI_FROM_SYMFONY_CONSOLE'] : false;

if (isset($_ENV['APP_ENV']) && $_ENV['TEST_GENERATE_DB'] && !$_ENV['CLI_FROM_SYMFONY_CONSOLE']) {
    if (!file_exists(sprintf('%s/../var', __DIR__))) {
        mkdir(sprintf('%s/../var', __DIR__), 0777);
    }

    passthru(sprintf(
        'APP_ENV=%s php "%s/../bin/console" doctrine:database:drop --force',
        $_ENV['APP_ENV'],
        __DIR__
    ));

    passthru(sprintf(
        'APP_ENV=%s php "%s/../bin/console" doctrine:database:create',
        $_ENV['APP_ENV'],
        __DIR__
    ));

    passthru(sprintf(
        'APP_ENV=%s php "%s/../bin/console" doctrine:schema:create',
        $_ENV['APP_ENV'],
        __DIR__
    ));

    passthru(sprintf(
        'APP_ENV=%s php "%s/../bin/console" doctrine:fixtures:load --append --no-interaction',
        $_ENV['APP_ENV'],
        __DIR__
    ));
}

use Symfony\Component\Dotenv\Dotenv;

require dirname(__DIR__).'/../vendor/autoload.php';

$_ENV['APP_ENV'] = 'test';
$_SERVER['APP_ENV'] = 'test';

if ('prod' !== $_SERVER['APP_ENV']) {
    if (!class_exists(Dotenv::class)) {
        throw new RuntimeException('The "APP_ENV" environment variable is not set to "prod". Please run "composer require symfony/dotenv" to load the ".env" files configuring the application.');
    }

    (new Dotenv())->loadEnv(dirname(__DIR__).'/.env');
}

//$_SERVER['APP_DEBUG'] = $_SERVER['APP_DEBUG'] ?? $_ENV['APP_DEBUG'] ?? 'prod' !== $_SERVER['APP_ENV'];
//$_SERVER['APP_DEBUG'] = $_ENV['APP_DEBUG'] = (int) $_SERVER['APP_DEBUG'] || filter_var($_SERVER['APP_DEBUG'], FILTER_VALIDATE_BOOLEAN) ? '1' : '0';
$_SERVER['APP_DEBUG'] = $_ENV['APP_DEBUG'] = 0;
