<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class FavoritesTest extends TestCase
{
    public function testsFavoritesAreCreatedCorrectly()
    {		
		\DB::table('forecasts')->truncate();
		\DB::table('favorites')->truncate();
		\DB::table('cities')->delete();
		\DB::table('users')->delete();


		$user = \App\Users::create([
            'Name' => 'Mack',
            'e-mail' => 'mack@theknife.com',
        ]);

		\App\Cities::create([
            'City' => 'Weimar',
            'Country' => 'DE',
        ]);

		$payload = [
            'User' => $user['User Id'],
            'City' => 'Weimar',
			'Country' => 'DE',
        ];

        $this->json('POST', '/api/favorites', $payload, [])
            ->assertStatus(200)
            ->assertJson(['User' => $user['User Id'], 'City' => 'Weimar', 'Country' => 'DE']);

		\DB::table('forecasts')->truncate();
		\DB::table('favorites')->truncate();
		\DB::table('cities')->delete();
		\DB::table('users')->delete();

    }
	
	public function testGetUserFavorites()
    {
		\DB::table('forecasts')->truncate();
		\DB::table('favorites')->truncate();
		\DB::table('cities')->delete();
		\DB::table('users')->delete();

        $user = \App\Users::create([
            'Name' => 'weil',
            'e-mail' => 'weil@kurt.de'
        ]);

		\App\Cities::create([
            'City' => 'Weimar',
            'Country' => 'DE',
        ]);

		\App\Cities::create([
            'City' => 'Weinmar',
            'Country' => 'DE',
        ]);
		
		$c1 = ['User' => $user['User Id'], 'City' => 'Weimar', 'Country' => 'DE'];
		\App\Favorites::create($c1);
		
		$c2 = ['User' => $user['User Id'], 'City' => 'Weinmar', 'Country' => 'DE'];
		\App\Favorites::create($c2);

        $response = $this->json('GET', '/api/favorites/' . $user['User Id'], [], [])
            ->assertStatus(200)
            ->assertJson([
                [ 'User' => $user['User Id'], 'City' => 'Weimar', 'Country' => 'DE' ],
                [ 'User' => $user['User Id'], 'City' => 'Weinmar', 'Country' => 'DE' ]])
			->assertJsonStructure([
                '*' => ['User', 'City', 'Country'],
            ]);

		\DB::table('forecasts')->truncate();
		\DB::table('favorites')->truncate();
		\DB::table('cities')->delete();
		\DB::table('users')->delete();

    }

	public function testsFavoritesAreDeletedCorrectly()
    {
		\DB::table('forecasts')->truncate();
		\DB::table('favorites')->truncate();
		\DB::table('cities')->delete();
		\DB::table('users')->delete();

        $user = \App\Users::create([
            'Name' => 'weil',
            'e-mail' => 'weil@kurt.de'
        ]);

		\App\Cities::create([
            'City' => 'Weimar',
            'Country' => 'DE',
        ]);
		
		$input = ['User' => $user['User Id'], 'City' => 'Weimar', 'Country' => 'DE'];
		\App\Favorites::create($input);

        $this->json('DELETE', '/api/favorites/' . $user['User Id'] . '/city/Weimar/country/DE' , [], [])->assertStatus(204);

		\DB::table('forecasts')->truncate();
		\DB::table('favorites')->truncate();
		\DB::table('cities')->delete();
		\DB::table('users')->delete();

    }

	public function testUserFavoritesAreDeletedCorrectly()
    {
		\DB::table('forecasts')->truncate();
		\DB::table('favorites')->truncate();
		\DB::table('cities')->delete();
		\DB::table('users')->delete();

        $user = \App\Users::create([
            'Name' => 'weil',
            'e-mail' => 'weil@kurt.de'
        ]);

		\App\Cities::create([
            'City' => 'Weimar',
            'Country' => 'DE',
        ]);

		\App\Cities::create([
            'City' => 'Weinmar',
            'Country' => 'DE',
        ]);
	
		$c = ['User' => $user['User Id'], 'City' => 'Weimar', 'Country' => 'DE'];
		\App\Favorites::create($c);
		
		\App\Favorites::create([
            'User' => $user['User Id'],
            'City' => 'Weinmar',
            'Country' => 'DE',
        ]);

        $response = $this->json('DELETE', '/api/favorites/' . $user['User Id'], [], [])->assertStatus(204);

		\DB::table('forecasts')->truncate();
		\DB::table('favorites')->truncate();
		\DB::table('cities')->delete();
		\DB::table('users')->delete();
  }


}
