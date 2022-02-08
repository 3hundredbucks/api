<?php

use Illuminate\Database\Capsule\Manager as Capsule;

require($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');

$capsule = new Capsule;

$capsule->addConnection([
    "driver" => "pgsql",
    'host' => $_ENV['DB_HOST'],
    'database' => $_ENV['DB_NAME'],
    'username' => $_ENV['DB_USER'],
    'password' => $_ENV['DB_PASSWORD']
]);

//Make this Capsule instance available globally.
$capsule->setAsGlobal();
$capsule->bootEloquent();