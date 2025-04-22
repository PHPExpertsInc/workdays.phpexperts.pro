<?php
use Illuminate\Database\Capsule\Manager as Capsule;

require __DIR__ . '/../vendor/autoload.php';

$capsule = new Capsule;

$capsule->addConnection([
    'driver'    => env('DB_CONNECTION'),
    'host'      => env('DB_HOST'),
    'database'  => env('DB_DATABASE'),
    'username'  => env('DB_USERNAME'),
    'password'  => env('DB_PASSWORD'),
    'charset'   => 'utf8',
    'schema'    => 'public',
]);

// Set the event dispatcher used by Eloquent models (optional)
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;

$capsule->setEventDispatcher(new Dispatcher(new Container));

// Make the Capsule instance available globally via static methods
$capsule->setAsGlobal();


