<?php


namespace App\Controllers;


use Symfony\Component\HttpFoundation\Request;

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
}