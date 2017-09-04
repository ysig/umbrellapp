<?php

use Illuminate\Database\Seeder;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get("database/seeds/city.list.json");
        $data = json_decode($json);
        $i = 0;
        // add cities from the json file
        foreach ($data as $obj){
            if($i>5000){
				break;
			}else{
				$exists = App\Cities::where([
				    ['City', '=', $obj->name],
					['Country','=',$obj->country],
					])->first();
				if($exists <> null){
					continue;			
				}
				App\Cities::create([
					'City' => $obj->name,
					'Country' => $obj->country
			    ]);
			}
            $i++;
        }

    }
}
