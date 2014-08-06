<?php

use Illuminate\Database\Migrations\Migration;

class CreateNavigationTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('fs_navigation', function($table)
		{
			// storage engine
			$table->engine = 'MyISAM';
			// fields
			$table->increments('id');
			$table->integer('parent_id');
			$table->integer('position');
			$table->integer('article_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('fs_navigation');
	}

}