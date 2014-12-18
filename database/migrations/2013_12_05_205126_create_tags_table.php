<?php

use Illuminate\Database\Migrations\Migration;

class CreateTagsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('fs_tags', function($table)
		{
			// storage engine
			$table->engine = 'MyISAM';
			// fields
			$table->increments('id','true');
			$table->string('name');
			$table->boolean('internal')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('fs_tags');
	}

}
