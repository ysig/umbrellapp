<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('User Id');
            $table->string('Name',255);
            $table->string('e-mail',255);
            $table->unique('e-mail');
			$table->unique(array('e-mail','Name'));
        });
		\DB::update("ALTER TABLE users AUTO_INCREMENT = 1;");
		\DB::update("SET @@auto_increment_increment=10;");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::dropIfExists('favorites');
        Schema::dropIfExists('users');
    }
}
