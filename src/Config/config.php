<?php

require('vendor/autoload.php');

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;
use Illuminate\Database\Capsule\Manager as Capsule;

/**
 * Create an set global the database configuration
 */
function connectDB()
{
    $capsule = new Capsule();

    $capsule->addConnection([
        'driver'    => 'mysql',
        'host'      => '127.0.0.1',
        'username'  => 'root',
        'password'  => 'otighe',
        'database'  => 'eloquent',
        'charset'   => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix'    => '',
    ]);

    $capsule->setAsGlobal();

    $capsule->bootEloquent();
}

