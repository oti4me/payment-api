<?php

require('vendor/autoload.php');

use Symfony\Component\Dotenv\Dotenv;

$dotenv = new Dotenv();
$dotenv->load(__DIR__ . '/../.env');

function env($variable, $default = null)
{
    return $_ENV[$variable] ?? $default;
}
