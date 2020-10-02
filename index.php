<?php

require ('vendor/autoload.php');

use App\Routes;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

connectDB();

$request = Request::createFromGlobals();

$response = new JsonResponse();

$routes = new Routes($request, $response);

$routes->registerHandlers();
