<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateTicketsTable.
 */
class CreateTicketsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tickets', function(Blueprint $table) {
            $table->increments('id');

            $table->string('file')->nullable();

            $table->string('subject');
            $table->text('message');

            $table->unsignedInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');

            $table->unsignedInteger('emission_id')->nullable();
            $table->foreign('emission_id')->references('id')->on('emissions');

            $table->unsignedInteger('transmitter_id');
            $table->foreign('transmitter_id')->references('id')->on('companies');

            $table->unsignedInteger('receiver_id');
            $table->foreign('receiver_id')->references('id')->on('companies');

            // 1: Activo, 0: Inactivo
            $table->smallInteger('status')->default(1);

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
		Schema::drop('tickets');
	}
}
