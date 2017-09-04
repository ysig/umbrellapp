<?php

use Illuminate\Database\Seeder;

class FavoritesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Favorites::truncate();
        $faker = \Faker\Factory::create();
        $uid = App\Users::all()->pluck('User Id')->toArray();
		$ccid = App\Cities::all()->pluck('Country','City')->toArray();
		$n_samples = 60;
        $i = 0;
	    while ($i < $n_samples) {
            $city = array_rand($ccid, 1);
            $country = $ccid[$city];
            $user = $faker->randomElement($uid);
			//check if the combination exists
            $exists = App\Favorites::where([
				    ['User', '=', $user],
				    ['City', '=', $city],
					['Country','=', $country],
					])->first();
			// to avoid duplicates
            if($exists === null){
	            App\Favorites::create([
	                'User' => $user,
	                'City' => $city,
	                'Country' => $country
	            ]);
				$i++;
			}
        }
		
    }
}
