<?php


use Phinx\Seed\AbstractSeed;

class Carts extends AbstractSeed
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
                'user_id'      => $faker->numberBetween(1, 10),
                'product_id'         => $faker->numberBetween(1, 10),
            ];
        }

        $this->table('carts')->insert($data)->saveData();
    }
}
