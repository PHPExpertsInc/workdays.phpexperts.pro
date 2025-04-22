#!/bin/env php
<?php declare(strict_types=1);

use Minicli\Command\CommandCall;

if (php_sapi_name() !== 'cli') {
    exit;
}

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/.framework/boot.php';


$app->registerCommand('greet', function (CommandCall $cli) use ($app, $p) {
    $args = $cli->getRawArgs();
    $name = $args[2] ?? 'World';
    echo $p->red("Hello, ")->bold()->lightCyan($name)->text("!\n");
}, '<name>', 'Emits a salutation.');

// Register new commands here...
$app->registerCommand('new', function (CommandCall $cli) {
}, '', 'new');

$app->runCommand($argv);
