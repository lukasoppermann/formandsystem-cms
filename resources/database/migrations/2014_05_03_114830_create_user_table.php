<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('fs_users', function($table)
		{
			$table->increments('id');
			$table->string('name',255);
			$table->string('email', 100)->unique();
	    $table->string('password', 64);
			$table->string('remember_token', 100);
	    $table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('fs_users');
	}

}
