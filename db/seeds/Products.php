<?php


use Phinx\Seed\AbstractSeed;

class Products extends AbstractSeed
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
                'name'      => $faker->name,
                'description'      => $faker->text,
                'user_id' => $faker->numberBetween(1, 10),
                'price'         => $faker->numberBetween(20, 100),
                'image_url'    => $faker->imageUrl(),
            ];
        }

        $this->table('products')->insert($data)->saveData();
    }
}
