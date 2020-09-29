<?php

require('vendor/autoload.php');

use Firebase\JWT\JWT;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\HttpFoundation\Response;
use Valitron\Validator;

$dotenv = new Dotenv();
$dotenv->load(__DIR__ . '/../.env');

/**
 * @param $variable
 * @param null $default
 * @return mixed|null
 */
function env($variable, $default = null)
{
    return $_ENV[$variable] ?? $default;
}

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
            'id' => @$data['id'],
            'email' => @$data['email']
        ],
    ];

    return JWT::encode($payload, env('JWT_SECRET'));
}

/**
 * @param $data
 * @return object
 */
function jwtDecode($data)
{
    return JWT::decode($data, env('JWT_SECRET'), array('HS256'));
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
    $v->rule('required', ['name', 'description', 'price', 'owner']);
    $v->rule('lengthMin', 'name', 3);
    $v->rule('lengthMin', 'description', 10);

    if (!$v->validate()) {
        return [null, ['status' => 'Failure', 'message' => 'validation error', 'code' => Response::HTTP_UNPROCESSABLE_ENTITY, 'error' => $v->errors()]];
    }

    return [null, null];
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
