<?php

use Dotenv\Dotenv;
use Illuminate\Container\Container;
use Illuminate\Database\Capsule\Manager;
use Illuminate\Database\Migrations\DatabaseMigrationRepository;
use Illuminate\Database\Migrations\Migrator;
use Illuminate\Events\Dispatcher;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Facade;
use Minicli\App;
use Minicli\Command\CommandCall;
use PHPExperts\ConsolePainter\ConsolePainter;
use PHPExperts\MiniApiBase\ApiKeyManager;

/** @var Manager $capsule */
require __DIR__ . '/../database/config.php';

$container = new Container;

// Set up the event dispatcher
$container->singleton('events', function() {
    return new Dispatcher($this);
});


$container->instance('db', $capsule->getDatabaseManager());
//$container->instance('db.schema', $capsule->getDatabaseManager()->getSchemaGrammar());

// Bind 'db.schema' so Schema facade can resolve the schema builder
$container->singleton('db.schema', function ($app) {
    return $app->make('db')->connection()->getSchemaBuilder();
});

// Set the container instance to Facade
Facade::setFacadeApplication($container);


$app = new App([
    'app_path' => [
        __DIR__ . '/src/Command',
    ],
    'theme' => '\Dracula',
    'debug' => false,
]);

$p = new ConsolePainter();

// Load environment variables from the .env file
$ensureDotEnv = function () {
    if (!file_exists(__DIR__ . '/../.env')) {
        if (file_exists('.env.dist')) {
            system('cp .env.dist .env');
        }

        file_put_contents('.env', '');
    }
};

$makeAppKey = function () {
    $appKey = env('APP_KEY');
    if (empty($appKey)) {
        $appKey = hash('sha256', bin2hex(random_bytes(8)));
        file_put_contents('.env', "\nAPP_KEY=$appKey\n", FILE_APPEND);
        putenv("APP_KEY=$appKey");
        $_ENV['APP_KEY'] = $appKey;
    }
};

$ensureDotEnv();

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$makeAppKey();

// Validate the environment variables
$validateEnv = function () use ($p) {
    $missing = false;
    foreach (['APP_KEY'] as $e) {
        if (empty($_ENV[$e])) {
            echo $p->bold()->red("ERROR: ")->lightCyan($e)->text(" is not set in ")->lightPurple('.env')->text(" or environment variable\n");
            $missing = true;
        }
    }

    if ($missing === true) {
        exit(1);
    }
};

$validateEnv();



$app->registerCommand('migrate', function () {
    global $capsule;

    $repository = new DatabaseMigrationRepository($capsule->getDatabaseManager(), 'migrations');
    if (!$repository->repositoryExists()) {
        $repository->createRepository();
    }

    $migrator = new Migrator($repository, $capsule->getDatabaseManager(), new Filesystem());
    $migrationKeys = $migrator->run(__DIR__ . '/../database/migrations');

    foreach ($migrationKeys as $filepath) {
        $migrationKey = basename($filepath, '.php');
        dump("Successfully ran the migration $migrationKey.");
    }

}, '<option>', 'Runs database migrations.');

$app->registerCommand('migrate:rollback', function () {
    global $capsule;

    $repository = new DatabaseMigrationRepository($capsule->getDatabaseManager(), 'migrations');
    if (!$repository->repositoryExists()) {
        $repository->createRepository();
    }

    $migrator = new Migrator($repository, $capsule->getDatabaseManager(), new Filesystem());
    $migrationKeys = $migrator->rollback(__DIR__ . '/../database/migrations');

    foreach ($migrationKeys as $filepath) {
        $migrationKey = basename($filepath, '.php');
        dump("Successfully rolled back the migration $migrationKey.");
    }

}, '', 'Rolls back one migration at a time.');


$app->registerCommand('api_key:issue', function (CommandCall $cli) use ($p) {
    $argv = $cli->getRawArgs();
    if (count($argv) < 3) {
        echo $p->bold()->red("ERROR: ")->text('Missing the "client" CLI argument.') . "\n";
        exit(1);
    }

    $client = $argv[2];

    $keyMaster = new ApiKeyManager();
    $apiKey = $keyMaster->createApiKey($client);

    echo $p->bold("       Here is your API Key:") . "\n";
    echo "\n";
    echo $p->bold()->yellow("            $apiKey\n");
    echo "\n";
    echo $p->bold()->red("      Store it now, because it will never be reshown.") . "\n";

}, '[client]', 'Issues a new API key for a client.');
