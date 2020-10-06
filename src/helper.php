<?php

require('vendor/autoload.php');

use Firebase\JWT\JWT;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Valitron\Validator;

$dotenv = new Dotenv();
$dotenv->load(__DIR__ . '/../.env');

/**
 * @param $data
 * @return string
 */
function jwtEncode($data)
{
    $payload = [
        "iss" => 'localhost',
        'exp' => time() + 8.64e+7,
        "user" => [
            'id' => $data['id'],
            'email' => $data['email'],
            'firstName' => $data['firstName'],
            'lastName' => $data['lastName']
        ],
    ];

    return JWT::encode($payload, envGet('JWT_SECRET'));
}

/**
 * @param $data
 * @return array
 */
function jwtDecode($data)
{
    try {
        return [JWT::decode($data, envGet('JWT_SECRET'), array('HS256')), null];
    }
    catch (Exception $e) {
        return [null, $e];
    }
}

/**
 * @param $data
 * @return array
 */
function validateUserRegistrationInput($data)
{
    $v = new Validator($data);
    $v->rule('required', ['firstName', 'lastName', 'password', 'email']);
    $v->rule('email', 'email');
    $v->rule('lengthMin', 'firstName', 3);
    $v->rule('lengthMin', 'lastName', 3);
    $v->rule('lengthMin', 'password', 5);

    if (!$v->validate()) {
        return [null, ['status' => 'Failure', 'message' => 'validation error', 'code' => Response::HTTP_UNPROCESSABLE_ENTITY, 'error' => $v->errors()]];
    }

    return [null, null];
}

/**
 * @param $data
 * @return array|null[]
 */
function validateUserLoginInput($data)
{
    $v = new Validator($data);
    $v->rule('required', ['password', 'email']);
    $v->rule('email', 'email');
    $v->rule('lengthMin', 'password', 5);

    if (!$v->validate()) {
        return [null, ['status' => 'Failure', 'message' => 'validation error', 'code' => Response::HTTP_UNPROCESSABLE_ENTITY, 'error' => $v->errors()]];
    }

    return [null, null];
}

/**
 * @param $data
 * @return array|null[]
 */
function validateProductCreationInput($data)
{
    $v = new Validator($data);
    $v->rule('required', ['name', 'description', 'price', 'image_url']);
    $v->rule('lengthMin', 'name', 3);
    $v->rule('lengthMin', 'description', 10);

    if (!$v->validate()) {
        return [null, ['status' => 'Failure', 'message' => 'validation error', 'code' => Response::HTTP_UNPROCESSABLE_ENTITY, 'error' => $v->errors()]];
    }

    return [null, null];
}

/**
 * @param $data
 * @return array|null[]
 */
function validateAddToCartInput($data)
{
    $v = new Validator($data);

    $v->rule('required', ['product_id']);

    return (!$v->validate()) ?
        [null, [
            'status' => 'Failure',
            'message' => 'validation error',
            'code' => Response::HTTP_UNPROCESSABLE_ENTITY,
            'error' => $v->errors()]] :
        [null, null];
}

/**
 * @param $response
 * @param $data
 * @param int $statusCode
 * @return mixed
 */
function response($response, $data, $statusCode = Response::HTTP_OK)
{
    switch ($statusCode) {
        case Response::HTTP_OK:
        case Response::HTTP_CREATED:
            $status = 'Success';
            break;
        default:
            $status = 'Failure';
    }

    return $response->setStatusCode($statusCode)
        ->setData([
            'status' => $status,
            'body' => $data
        ])->send();
}

/**
 * @param Request $request
 * @return mixed
 */
function isAuthenticated(Request $request)
{
    $token = $request->headers->get('authorization');

    [$decoded, $error] = jwtDecode($token);

    if ($error) return false;

    $request->user = $decoded->user;

    return true;
}

/**
 * @param $req
 */
function setCorsHeaders($response)
{
    $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    $response->headers->set('Access-Control-Allow-Origin', '*');
    $response->headers->set('Access-Control-Allow-Headers', 'content-type, Authorization');
}

/**
 * @param $key
 */
function envGet($key) {
    return $_ENV[$key] ?? $_SERVER[$key];
}
