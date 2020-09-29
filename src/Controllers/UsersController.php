<?php

namespace App\Controllers;

use App\Repositories\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UsersController
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
        $body = json_decode($request->getContent(), true);

        [$user, $error] = $this->userRepository->register($body);

        if ($error) {
            return $response->setStatusCode($error['code'])
                ->setData([
                    'status' => 'Failure',
                    'body' => $error
                ])->send();
        }

        return $response->setStatusCode(Response::HTTP_CREATED)
            ->setData([
                'status' => 'Success',
                'body' => jwtEncode($user)
            ])->send();

    }

}
