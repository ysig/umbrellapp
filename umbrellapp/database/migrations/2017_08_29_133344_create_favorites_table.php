<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFavoritesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('favorites', function (Blueprint $table) {
            $table->integer('User')->unsigned();
			$table->string('City',255);
			$table->string('Country',255);
            $table->primary(array('User','City', 'Country'));
            $table->foreign('User')->references('User Id')->on('users');
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
        Schema::dropIfExists('favorites');
    }
}
