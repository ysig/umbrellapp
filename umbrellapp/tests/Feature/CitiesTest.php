<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CitiesTest extends TestCase
{
    public function testsCitiesAreCreatedCorrectly()
    {
		\DB::table('forecasts')->truncate();
		\DB::table('favorites')->truncate();
		\DB::table('cities')->delete();
     
		$payload = ['City' => 'Atlantis', 'Country' => 'ZS'];

        $this->json('POST', '/api/cities', $payload, [])
            ->assertStatus(200)
            ->assertJson(['City' => 'Atlantis', 'Country' => 'ZS']);

		\DB::table('forecasts')->truncate();
		\DB::table('favorites')->truncate();
		\DB::table('cities')->delete();
	}
	
	public function testsExistential()
    {
		\DB::table('forecasts')->truncate();
		\DB::table('favorites')->truncate();
		\DB::table('cities')->delete();

		\App\Cities::create(['City' => 'Atlantis', 'Country' => 'ZS']);

        $this->json('GET', '/api/cities/exists/city/Atlantis/country/ZS', [], [])->assertStatus(200);

		\DB::table('forecasts')->truncate();
		\DB::table('favorites')->truncate();
		\DB::table('cities')->delete();    
	}

	public function testsCitiesAreDeletedCorrectly()
    {
		\DB::table('forecasts')->truncate();
		\DB::table('favorites')->truncate();
		\DB::table('cities')->delete();
		\App\Cities::create([
            'City' => 'Atlantis',
            'Country' => 'ZS',
        ]);

        $this->json('DELETE', '/api/cities/city/Atlantis/country/ZS' , [], [])->assertStatus(204);

		\DB::table('forecasts')->truncate();
		\DB::table('favorites')->truncate();
		\DB::table('cities')->delete();
   }
}
