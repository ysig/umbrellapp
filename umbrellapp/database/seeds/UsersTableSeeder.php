<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$faker = \Faker\Factory::create();

        // And now, let's create a few users in our database:
        for ($i = 0; $i < 50; $i++) {
            App\Users::create([
                'Name' => $faker->name,
                'e-mail' => $faker->email
            ]);
        }
    }
}
