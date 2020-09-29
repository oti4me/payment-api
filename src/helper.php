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
            'id' => $data['id'],
            'email' => $data['email']
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
