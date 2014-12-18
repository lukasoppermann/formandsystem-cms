<?php

use Illuminate\Database\Migrations\Migration;

class CreateContentTagTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('fs_content_tags', function($table)
		{
			// storage engine
			$table->engine = 'MyISAM';
			// fields
			$table->increments('id');

			$table->integer('tag_id')->unsigned()->index();
			$table->foreign('tag_id')->references('id')->on('content')->onDelete('cascade');

			$table->integer('content_id')->unsigned()->index();
			$table->foreign('content_id')->references('id')->on('tags')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('fs_content_tags');
	}

}
