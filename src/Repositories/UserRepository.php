<?php

namespace App\Repositories;

use App\Models\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;
use Symfony\Component\HttpFoundation\Response;

class UserRepository extends BaseRepository
{
    private EntityManager $entityManager;

    /**
     * UserRepository constructor.
     */
    public function __construct()
    {
        $this->entityManager = getEntityManager();
    }

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

        $userRepository = $this->entityManager->getRepository('App\\Models\\User');

        $exists = $userRepository->findOneBy([
            'email' => $userInfo['email']
        ]);

        if ($exists) {
            return [
                null,
                ['status' => 'Failure', 'message' => 'user with email ' . $userInfo['email'] . ' already exists', 'code' => Response::HTTP_CONFLICT]
            ];
        }

        try {
            $user = new User();

            $user->setFirstName($userInfo['firstName']);
            $user->setLastName($userInfo['lastName']);
            $user->setEmail($userInfo['email']);
            $user->setPassword(password_hash($userInfo['password'], PASSWORD_BCRYPT));

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            return [$user->toArray(), null];
        } catch (ORMException $e) {
            var_dump($e);
        }

    }

    public function userLogin($userInfo)
    {
        [$_, $error] = validateUserLoginInput($userInfo);

        if ($error) return [null, $error];

        $userRepository = $this->entityManager->getRepository('App\\Models\\User');

        $user = $userRepository->findOneBy([
            'email' => $userInfo['email']
        ]);

        var_dump($user->getProducts());


        if ($user && password_verify($userInfo['password'], $user->getPassword())) {
            return [$user->toArray(), null];
        }

        return [
            null,
            ['status' => 'Failure', 'message' => 'Email or password incorrect', 'code' => Response::HTTP_BAD_REQUEST]
        ];
    }

}
