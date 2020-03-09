<?php

use Symfony\Component\Dotenv\Dotenv;

require dirname(__DIR__).'/vendor/autoload.php';


function runCommand($command)
{
    echo (sprintf("Executing: %s\r\n", $command));
    passthru($command);
}

if (isset($_ENV['BOOTSTRAP_CLEAR_DB_ENV'])) {

    // executes the commands:
    // php bin/console ca:cl
    $command = '';
    runCommand(sprintf(
        'php "%s/../bin/console" ca:cl',
        __DIR__
    ));

    // executes the commands:
    // php bin/console doctrine:database:drop --force
    $command = '';
    runCommand(sprintf(
        'php "%s/../bin/console" doctrine:database:drop --force',
        __DIR__
    ));

    // php bin/console doctrine:database:create
    runCommand(sprintf(
        'php "%s/../bin/console" doctrine:database:create',
        __DIR__
    ));

    // php bin/console doctrine:schema:create
    runCommand(sprintf(
        'php "%s/../bin/console" doctrine:schema:create',
        __DIR__
    ));

    // php bin/console doctrine:fixtures:load -n
    runCommand(sprintf(
        'php "%s/../bin/console" doctrine:fixtures:load -n',
        __DIR__
    ));
}

if (file_exists(dirname(__DIR__).'/config/bootstrap.php')) {
    require dirname(__DIR__).'/config/bootstrap.php';
} elseif (method_exists(Dotenv::class, 'bootEnv')) {
    (new Dotenv())->bootEnv(dirname(__DIR__).'/.env');
}
