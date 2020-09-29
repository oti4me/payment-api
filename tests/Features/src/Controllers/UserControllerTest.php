<?php

use Faker\Factory;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use PHPUnit\Framework\TestCase;


class UserControllerTest extends TestCase
{
    private Client $http;
    private $faker;

    function test_can_registration_a_user()
    {
        $data = [
            "firstName" => $this->faker->firstName,
            "lastName" => $this->faker->lastName,
            "email" => $this->faker->email,
            "password" => $this->faker->password
        ];

        try {
            $response = $this->http->request('POST', 'payment-api/api/v1/register', [
                'json' => $data
            ]);
            $body = json_decode($response->getBody()->getContents())->body;

            [$user, $error] = jwtDecode($body, env('JWT_SECRET'))->user;

            $this->assertEquals(201, $response->getStatusCode());
            $this->assertEquals($data['email'], $user->email);
        } catch (GuzzleException $e) {
            var_dump($e);
        }
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->faker = Factory::create();

        $this->http = new GuzzleHttp\Client(['base_uri' => 'http://localhost/']);
    }

}