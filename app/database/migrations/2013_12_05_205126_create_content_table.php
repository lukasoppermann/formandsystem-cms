<?php

use Illuminate\Database\Migrations\Migration;

class CreateContentTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('fs_content', function($table)
		{
			$table->increments('id');
			$table->smallInteger('menu_id');
			$table->string('menu_label');
			$table->boolean('status');
			$table->string('language', 2);
			$table->smallInteger('type');
			$table->string('title');
			$table->text('content');
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
		Schema::drop('fs_content');
	}

}