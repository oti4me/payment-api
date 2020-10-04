<?php

require('vendor/autoload.php');

use Illuminate\Database\Capsule\Manager as Capsule;
use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Create an set global the database configuration
 */
function connectDB()
{
    try {
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
    } catch(Exception $exception) {
        new JsonResponse($exception, Response::HTTP_INTERNAL_SERVER_ERROR, [], true);
    }

}

/**
 * @return Client
 */
function getHttp() {
    return new Client();
}
