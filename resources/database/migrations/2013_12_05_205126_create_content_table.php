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
			$table->increments('id','true');
			$table->integer('article_id')->nullable();
			$table->string('menu_label')->nullable();
			$table->string('link')->index()->nullable();
			$table->boolean('published');
			$table->string('language', 2)->nullable();
			$table->longtext('data')->nullable();
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
