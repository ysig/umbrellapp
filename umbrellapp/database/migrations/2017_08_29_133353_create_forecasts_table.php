<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForecastsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forecasts', function (Blueprint $table) {
            $table->string('City',255);
            $table->string('Country',255);
            $table->date('Date');
			$table->time('Time')->nullable();
            $table->enum('weather', ['Rain', 'Clouds','Sunny','Few Clouds','Clear','Snow']);
			$table->integer('temp_max');
			$table->integer('temp_min');
            $table->primary(array('City', 'Country','Date','Time'));
            $table->foreign(array('City','Country'))->references(array('City','Country'))->on('cities');	
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::dropIfExists('cities');
        Schema::dropIfExists('forecasts');
    }
}
