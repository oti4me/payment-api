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
            'driver'    => envGet('DB_DRIVER'),
            'host'      => envGet('DB_HOST'),
            'username'  => envGet('DB_USERNAME'),
            'password'  => envGet('DB_PASSWORD'),
            'database'  => envGet('DB_DATABASE'),
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
