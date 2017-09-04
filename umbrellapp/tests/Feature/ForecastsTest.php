<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ForecastsTest extends TestCase
{

    public function testsForecastsAreCreatedCorrectly()
    {		

		\DB::table('forecasts')->truncate();
		\DB::table('favorites')->truncate();
		\DB::table('cities')->delete();
		\DB::table('users')->delete();


	    \App\Cities::create(['City' => 'Weimar', 'Country' => 'DE']);

		$faker = \Faker\Factory::create();		

		$sd = $faker->date($format = 'Y-m-d', $max = 'now');
		$st = $faker->time($format = 'H:i:s', $max = 'now');

		$payload = ['City' => 'Weimar','Country' => 'DE','Date' => $sd,'Time' => $st,'weather' => 'Clouds','temp_max' => '20','temp_min' => '-10'];

        $this->json('POST', '/api/forecasts', $payload, [])
            ->assertStatus(200)
            ->assertJson($payload);

		\DB::table('forecasts')->truncate();
		\DB::table('favorites')->truncate();
		\DB::table('cities')->delete();
		\DB::table('users')->delete();

    }
	
	public function testForecastsAreUpdatedCorectly()
    {
		\DB::table('forecasts')->truncate();
		\DB::table('favorites')->truncate();
		\DB::table('cities')->delete();
		\DB::table('users')->delete();

        \App\Cities::create(['City' => 'Weimar', 'Country' => 'DE']);

		$faker = \Faker\Factory::create();		

		$sd = $faker->date($format = 'Y-m-d', $max = 'now');
		$st = $faker->time($format = 'H:i:s', $max = 'now');

		$payload = ['City' => 'Weimar','Country' => 'DE','Date' => $sd,'Time' => $st,'weather' => 'Clouds','temp_max' => '20','temp_min' => '-10'];
		\App\Forecast::create($payload);

		$responses_payload = ['City' => 'Weimar', 'Country' => 'DE', 'Date' => $sd, 'Time' => $st, 'weather' => 'Sunny', 'temp_max' => '10', 'temp_min' => '0'];
		$rsp = ['weather' => 'Sunny', 'temp_max' => '10', 'temp_min' => '0'];
        $response = $this->json('PUT', '/api/forecasts/city/Weimar/country/DE/date/'. $sd . '/time/' . $st, $rsp, [])
            ->assertStatus(200)
            ->assertJson($responses_payload);

		\DB::table('forecasts')->truncate();
		\DB::table('favorites')->truncate();
		\DB::table('cities')->delete();
		\DB::table('users')->delete();

    }

	public function testsForecastsAreDeletedCorrectly()
    {
		\DB::table('forecasts')->truncate();
		\DB::table('favorites')->truncate();
		\DB::table('cities')->delete();
		\DB::table('users')->delete();

        \App\Cities::create([
            'City' => 'Weimar',
            'Country' => 'DE',
        ]);

		$faker = \Faker\Factory::create();		

		$sd = $faker->date($format = 'Y-m-d', $max = 'now');
		$st = $faker->time($format = 'H:i:s', $max = 'now');

		$payload = ['City' => 'Weimar', 'Country' => 'DE', 'Date' => $sd, 'Time' => $st, 'weather' => 'Clouds', 'temp_max' => '20', 'temp_min' => '-10'];
		\App\Forecast::create($payload);

        $this->json('DELETE', '/api/forecasts/city/Weimar/country/DE/date/' . $sd . '/time/' . $st, [], [])->assertStatus(204);

		\DB::table('forecasts')->truncate();
		\DB::table('favorites')->truncate();
		\DB::table('cities')->delete();
		\DB::table('users')->delete();

    }

	public function testForecastsAreListedCorrectly()
    {
		\DB::table('forecasts')->truncate();
		\DB::table('favorites')->truncate();
		\DB::table('cities')->delete();
		\DB::table('users')->delete();


		\App\Cities::create([
            'City' => 'Weimar',
            'Country' => 'DE',
        ]);

		\App\Cities::create([
            'City' => 'Weinmar',
            'Country' => 'DE',
        ]);
	
		$faker = \Faker\Factory::create();		

		$sd = $faker->date($format = 'Y-m-d', $max = 'now');
		$st = $faker->time($format = 'H:i:s', $max = 'now');

		$payload = ['City' => 'Weimar', 'Country' => 'DE', 'Date' => $sd, 'Time' => $st, 'weather' => 'Clouds', 'temp_max' => '20',	'temp_min' => '-10'];
		\App\Forecast::create($payload);
		

		$sd2 = $faker->date($format = 'Y-m-d', $max = 'now');
		$st2 = $faker->time($format = 'H:i:s', $max = 'now');

		$payload2 = ['City' => 'Weinmar', 'Country' => 'DE', 'Date' => $sd2, 'Time' => $st2, 'weather' => 'Sunny', 'temp_max' => '10', 'temp_min' => '0'];
		\App\Forecast::create($payload2);

		$response = $this->json('GET', '/api/forecasts/', [], [])
            ->assertStatus(200)
            ->assertJson([$payload, $payload2])
            ->assertJsonStructure([
                '*' => ['City', 'Country', 'Date', 'Time', 'weather', 'temp_max', 'temp_min' ],
            ]);

		\DB::table('forecasts')->truncate();
		\DB::table('favorites')->truncate();
		\DB::table('cities')->delete();
		\DB::table('users')->delete();

    }

	public function testForecastsAreListedCorrectlyByCity()
    {
		\DB::table('forecasts')->truncate();
		\DB::table('favorites')->truncate();
		\DB::table('cities')->delete();
		\DB::table('users')->delete();


		\App\Cities::create([
            'City' => 'Weimar',
            'Country' => 'DE',
        ]);

	
		$faker = \Faker\Factory::create();		

		$sd = $faker->date($format = 'Y-m-d', $max = 'now');
		$st = $faker->time($format = 'H:i:s', $max = 'now');

		$payload = ['City' => 'Weimar', 'Country' => 'DE', 'Date' => $sd, 'Time' => $st, 'weather' => 'Clouds', 'temp_max' => '20', 'temp_min' => '-10'];
		\App\Forecast::create($payload);
		

		$sd2 = $faker->date($format = 'Y-m-d', $max = 'now');
		$st2 = $faker->time($format = 'H:i:s', $max = 'now');

		$payload2 = ['City' => 'Weimar', 'Country' => 'DE', 'Date' => $sd2, 'Time' => $st2, 'weather' => 'Sunny', 'temp_max' => '10', 'temp_min' => '0'];
		\App\Forecast::create($payload2);

		if($sd>$sd2){
			$result = [$payload, $payload2];
		}elseif($sd==$sd2){
			if($st1>=$st2){
				$result = [$payload, $payload2];
			}
			else{
				$result = [$payload2, $payload];
			}
		}else{
			$result = [$payload2, $payload];
		}

		$response = $this->json('GET', '/api/forecasts/city/Weimar/country/DE', [], [])->assertStatus(200)->assertJson($result);

		\DB::table('forecasts')->truncate();
		\DB::table('favorites')->truncate();
		\DB::table('cities')->delete();
		\DB::table('users')->delete();

    }

	public function testForecastsAreListedCorrectlyByCityDate()
    {
		\DB::table('forecasts')->truncate();
		\DB::table('favorites')->truncate();
		\DB::table('cities')->delete();
		\DB::table('users')->delete();


		\App\Cities::create([
            'City' => 'Weimar',
            'Country' => 'DE',
        ]);

		\App\Cities::create([
            'City' => 'Weinmar',
            'Country' => 'DE',
        ]);
	
		$faker = \Faker\Factory::create();		

		$sd = $faker->date($format = 'Y-m-d', $max = 'now');
		$st = $faker->time($format = 'H:i:s', $max = 'now');

		$payload = ['City' => 'Weimar', 'Country' => 'DE', 'Date' => $sd, 'Time' => $st, 'weather' => 'Clouds', 'temp_max' => '20', 'temp_min' => '-10'];
		\App\Forecast::create($payload);
		

		$st2 = $faker->time($format = 'H:i:s', $max = 'now');
		$payload2 = ['City' => 'Weimar', 'Country' => 'DE', 'Date' => $sd, 'Time' => $st2, 'weather' => 'Sunny', 'temp_max' => '10', 'temp_min' => '0'];

		if($st>=$st2){
			$result = [$payload, $payload2];
		}else{
			$result = [$payload2, $payload];
		}
		\App\Forecast::create($payload2);

		$response = $this->json('GET', '/api/forecasts/city/Weimar/country/DE/date/' . $sd, [], [])
            ->assertStatus(200)
            ->assertJson($result);

		\DB::table('forecasts')->truncate();
		\DB::table('favorites')->truncate();
		\DB::table('cities')->delete();
		\DB::table('users')->delete();

   }

}
