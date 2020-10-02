<?php


use Phinx\Seed\AbstractSeed;

class Users extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        $data = [];

        for ($i = 0; $i < 10; $i++) {
            $data[] = [
                'firstName'      => $faker->userName,
                'lastName'      => sha1($faker->password),
                'password' => sha1('foo'),
                'email'         => $faker->email,
            ];
        }

        $this->table('users')->insert($data)->saveData();
    }
}
