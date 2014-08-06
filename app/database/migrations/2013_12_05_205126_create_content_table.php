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
			// storage engine
			$table->engine = 'MyISAM';
			// fields
			$table->increments('id');
			$table->integer('article_id');
			$table->string('menu_label')->nullable();
			$table->string('link')->index()->nullable();
			$table->boolean('status')->nullable();
			$table->string('language', 2);
			$table->smallInteger('type');
			$table->string('title')->nullable();
			$table->text('data')->nullable();
			$table->timestamps();
			$table->softDeletes();
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