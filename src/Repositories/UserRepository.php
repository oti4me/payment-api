<?php

namespace App\Repositories;

use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class UserRepository extends BaseRepository
{
    /**
     * Inserts user record to the database
     *
     * @param $userInfo
     * @return User|array
     */
    public function register($userInfo)
    {
        [$_, $error] = validateUserRegistrationInput($userInfo);

        if ($error) return [null, $error];

        $exists = User::where(['email' => $userInfo['email']])->first();

        if ($exists) {
            return [
                null,
                ['status' => 'Failure', 'message' => 'user with email ' . $userInfo['email'] . ' already exists', 'code' => Response::HTTP_CONFLICT]
            ];
        }
        try {
            $user = User::create([
                'firstName' => $userInfo['firstName'],
                'lastName' => $userInfo['lastName'],
                'email' => $userInfo['email'],
                'password' => password_hash($userInfo['password'], PASSWORD_BCRYPT)
            ]);

            return [$user->toArray(), null];
        } catch (\Exception $e) {
            return [null, $e];
        }

    }

    public function userLogin($userInfo)
    {
        [$_, $error] = validateUserLoginInput($userInfo);

        if ($error) return [null, $error];

        $user = User::where(['email' => $userInfo['email']])->first();

        if ($user && password_verify($userInfo['password'], $user->password)) {
            return [$user->toArray(), null];
        }

        return [
            null,
            ['status' => 'Failure', 'message' => 'Email or password incorrect', 'code' => Response::HTTP_BAD_REQUEST]
        ];
    }

}
