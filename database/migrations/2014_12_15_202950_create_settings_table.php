<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('fs_settings', function(Blueprint $table)
		{
			// storage engine
			$table->engine = 'MyISAM';
			// fields
			$table->increments('id','true');
			$table->string('group');
			$table->string('key')->unique();
			$table->longtext('setting')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('fs_settings');
	}

}
