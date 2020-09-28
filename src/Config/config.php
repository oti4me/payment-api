<?php

require('vendor/autoload.php');

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;

/**
 * Creates and return db object
 *
 * @return PDO
 */
function getDB()
{
    $dsn = env('DB_DRIVER') . ':dbname=' . env('DB_DATABASE') . ';host=' . env('DB_HOST');

    try {
        return new PDO($dsn, env('DB_USERNAME'), env('DB_PASSWORD'));
    } catch (PDOException $e) {
        (new JsonResponse())->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR)
            ->setData([
                'status' => 'Failure',
                'message' => $e->getMessage()
            ])->send();
    }
}

/**
 * Returns an entity of manager object
 *
 * @return EntityManager
 */
function getEntityManager()
{
    $config = Setup::createAnnotationMetadataConfiguration(array(getcwd() . '/src/Models'), true, null, null, false);

    $dbInfo = [
        'dbname' => env('DB_DATABASE'),
        'user' => env('DB_USERNAME'),
        'password' => env('DB_PASSWORD'),
        'host' => env('DB_HOST'),
        'driver' => 'pdo_mysql',
    ];

    try {
        return EntityManager::create($dbInfo, $config);
    } catch (ORMException $e) {
        var_dump($e);
    }
}
