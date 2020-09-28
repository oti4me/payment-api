<?php

namespace App\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;


class WelcomeController
{
    /**
     * Handles request for the home route
     *
     * @param Request $request
     * @param JsonResponse $response
     */
    public function index(Request $request, JsonResponse $response)
    {
        $response->setData([
            'status' => Response::HTTP_OK,
            'message' => 'Welcome to the Shopping API, consult the API documentation!!'
        ])->send();
    }
}
