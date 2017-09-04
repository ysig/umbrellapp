<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
	public function testsUsersAreCreatedCorrectly()
    {
		\DB::table('favorites')->truncate();
		\DB::table('users')->delete();


        $payload = [
            'Name' => 'Andrey',
            'e-mail' => 'andrey@mosfilm.ru',
        ];

		// to be tested in an empty database

        $this->json('POST', '/api/users', $payload, [])
            ->assertStatus(200)
            ->assertJson(['Name' => 'Andrey', 'e-mail' => 'andrey@mosfilm.ru']);

		\DB::table('favorites')->truncate();
		\DB::table('users')->delete();

    }

    public function testsUsersAreUpdatedCorrectly()
    {
		\DB::table('favorites')->truncate();
		\DB::table('users')->delete();

        $user = \App\Users::create([
            'Name' => 'Stanley',
			'e-mail' => 'stanley@mgm.us',
        ]);

		$payload = [
            'Name' => 'Stanley',
			'e-mail' => 'stanley@mgm.com',
        ];

        $response = $this->json('PUT', '/api/users/' . $user['User Id'], $payload, [])
            ->assertStatus(200)
            ->assertJson(['Name' => 'Stanley','e-mail' => 'stanley@mgm.com']);
		
		\DB::table('favorites')->truncate();
		\DB::table('users')->delete();
    }

    public function testsUsersAreDeletedCorrectly()
    {
		\DB::table('favorites')->truncate();
		\DB::table('users')->delete();

        $user = \App\Users::create([
            'Name' => 'Woody',
            'e-mail' => 'allen@woody.com',
        ]);

        $this->json('DELETE', '/api/users/' . $user['User Id'], [], [])
            ->assertStatus(204);

		\DB::table('favorites')->truncate();
		\DB::table('users')->delete();
    }

	public function testsUsersAreDeletedCorrectlyByName()
    {
		\DB::table('favorites')->truncate();
		\DB::table('users')->delete();

        $user = \App\Users::create([
            'Name' => 'Woody',
            'e-mail' => 'allen@woody.com',
        ]);

        $this->json('DELETE', '/api/users/name/' . 'Woody' . '/email/' . 'allen@woody.com', [], [])
            ->assertStatus(204);

		\DB::table('favorites')->truncate();
		\DB::table('users')->delete();

    } 

    public function testUsersAreListedCorrectly()
    {
		\DB::table('favorites')->truncate();
		\DB::table('users')->delete();


        \App\Users::create([
            'Name' => 'Stanley',
            'e-mail' => 'stan@mgm.com'
        ]);

        \App\Users::create([
            'Name' => 'Andrey',
            'e-mail' => 'andy@mosfilm.com'
        ]);

        $response = $this->json('GET', '/api/users', [], [])
            ->assertStatus(200)
            ->assertJson([
                [ 'Name' => 'Andrey', 'e-mail' => 'andy@mosfilm.com' ],
				[ 'Name' => 'Stanley', 'e-mail' => 'stan@mgm.com' ],
            ]);

		\DB::table('favorites')->truncate();
		\DB::table('users')->delete();

    }
	
	public function testGetById(){
		\DB::table('favorites')->truncate();
		\DB::table('users')->delete();


		$stan = \App\Users::create([
            'Name' => 'Stanley',
            'e-mail' => 'stan@mgm.com'
        ]);

        $response = $this->json('GET', '/api/users/' . $stan['User Id'], [], [])
            ->assertStatus(200)
            ->assertJson([
				'User Id' => $stan['User Id'], 
                'Name' => 'Stanley', 
                'e-mail' => 'stan@mgm.com' 
			]);

		\DB::table('favorites')->truncate();
		\DB::table('users')->delete();

    }

	public function testGetByName(){
		\DB::table('favorites')->truncate();
		\DB::table('users')->delete();


		$stan = \App\Users::create([
            'Name' => 'Stanley',
            'e-mail' => 'stan@mgm.com'
        ]);

        $response = $this->json('GET', '/api/users/name/' . 'Stanley' . '/email/' . 'stan@mgm.com', [], [])
            ->assertStatus(200)
            ->assertJson([
				'User Id' => $stan['User Id'], 
                'Name' => 'Stanley', 
                'e-mail' => 'stan@mgm.com' 
			]);

		\DB::table('favorites')->truncate();
		\DB::table('users')->delete();

    }

}

