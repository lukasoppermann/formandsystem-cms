<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountAccountDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_account_detail', function (Blueprint $table) {
            $table->uuid('account_id')->index();
            // $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');

            $table->uuid('account_detail_id')->index();
            // $table->foreign('account_detail_id')->references('id')->on('account_details')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('account_account_detail');
    }
}
