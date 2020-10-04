<?php

require('vendor/autoload.php');

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;
use Illuminate\Database\Capsule\Manager as Capsule;
use GuzzleHttp\Client;

/**
 * Create an set global the database configuration
 */
function connectDB()
{
    $capsule = new Capsule();

    $capsule->addConnection([
        'driver'    => env('DB_DRIVER'),
        'host'      => env('DB_HOST'),
        'username'  => env('DB_USERNAME'),
        'password'  => env('DB_PASSWORD'),
        'database'  => env('DB_DATABASE'),
        'charset'   => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix'    => '',
    ]);

    $capsule->setAsGlobal();

    $capsule->bootEloquent();
}

/**
 * @return Client
 */
function getHttp() {
    return new Client();
}
