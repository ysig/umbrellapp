<?php

use Illuminate\Database\Seeder;

class ForecastTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Forecast::truncate();
		$faker = \Faker\Factory::create();
        // $json = File::get("database/seeds/hourly_14.json");
		// this json seems to be problematic
		$ccid = App\Cities::all()->pluck('Country','City')->toArray();
		$num_cities = count($ccid);
		
		$cmax = rand((int) ($num_cities*0.5), $num_cities);
		for ($i=1; $i<=$cmax; $i++){
            $city = array_rand($ccid, 1);
            $country = $ccid[$city];
			
			# at most 10 forecasts
			$rmax = rand(3, 10);
			
			for ($j=1; $j<=$rmax; $j++){

				$rtemp1 = rand(-10,40);
				$rtemp2 = rand(-10,40);
				$rdate = $faker->date($format = 'Y-m-d', $min = 'now',  $interval = '+ 6 days');
				$rtime = $faker->time($format = 'H:i:s', $min = 'now',  $interval = '+ 6 days');
			
				App\Forecast::create([
							'City' => $city,
							'Country' => $country,
							'Date' => $rdate,
							'Time' => $rtime,
    		                'weather' => $faker->randomElement($array = array ('Rain', 'Clouds','Sunny','Few Clouds','Clear','Snow')),
    		                'temp_max' => max($rtemp1,$rtemp2),
    		                'temp_min' => min($rtemp1,$rtemp2),
						]);
			}
		}
	}
}
