<?php

namespace App\Controllers;

use App\Repositories\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UsersController extends BaseController
{
    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;

    /**
     * UsersController constructor.
     */
    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    /**
     * Registers a new user
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function register(Request $request, Response $response)
    {
        [$user, $error] = $this->userRepository->register($this->requestBodyToJson($request));

        if ($error) return response($response, $error, $error['code']);

        return response($response, jwtEncode($user), Response::HTTP_CREATED);
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return mixed
     */
    public function login(Request $request, Response $response)
    {
        [$user, $error] = $this->userRepository->userLogin($this->requestBodyToJson($request));

        if ($error) return response($response, $error, $error['code']);

        return response($response, jwtEncode($user));
    }

}
