<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentFragmentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('fs_content_fragments', function(Blueprint $table)
		{
			// storage engine
			$table->engine = 'MyISAM';
			// fields
			$table->increments('id');

			$table->integer('fragment_id')->unsigned()->index();
			$table->foreign('fragment_id')->references('id')->on('content')->onDelete('cascade');

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
		Schema::drop('fs_content_fragments');
	}

}
