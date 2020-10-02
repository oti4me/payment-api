<?php


namespace App\Controllers;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BaseController
{
    /**
     * @param $request
     * @return mixed
     */
    protected function requestBodyToJson(Request $request)
    {
        return json_decode($request->getContent(), true);
    }

    /**
     * @param $response
     * @return mixed
     */
    protected function unauthorised($response) {
        return response($response, 'Unauthorised', Response::HTTP_UNAUTHORIZED);
    }
}