<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStreamTable extends Migration {

	/**
	* Run the migrations.
	*
	* @return void
	*/
	public function up()
	{
		Schema::create('fs_stream', function(Blueprint $table)
		{
			// storage engine
			$table->engine = 'MyISAM';
			// fields
			$table->increments('id',true);
			$table->integer('parent_id')->default(0);
			$table->integer('article_id')->unique();
			$table->string('stream',255);
			$table->integer('position');
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
		Schema::drop('fs_stream');
	}

}
