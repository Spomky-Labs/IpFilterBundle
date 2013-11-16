<?php

use Symfony\Component\Console\Input\ArrayInput;

class TestHelper
{
    public static function executeCommand($application, $command, array $options = array()) {
        $options["--env"] = "test";
        $options["--no-interaction"] = true;
        $options["--quiet"] = true;
        $options = array_merge($options, array('command' => $command));

        $application->run(new ArrayInput($options));
    }

    public static function deleteDatabase() {
        $folder = __DIR__;
        foreach(array('/Functional/data.sqlite','/Functional/data.sqlite.bak') as $file){
            if(file_exists($folder . $file)) {
                unlink($folder . $file);
            }
        }
    }

    public static function backupDatabase() {
        copy(__DIR__ . '/Functional/data.sqlite', __DIR__ . '/Functional/data.sqlite.bak');
    }

    public static function restoreDatabase() {
        copy(__DIR__ . '/Functional/data.sqlite.bak', __DIR__ . '/Functional/data.sqlite');
    }
}