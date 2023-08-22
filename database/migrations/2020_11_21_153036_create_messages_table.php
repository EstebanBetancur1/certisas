<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateMessagesTable.
 */
class CreateMessagesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('messages', function(Blueprint $table) {
            $table->increments('id');

            $table->string('file')->nullable();

            $table->text('message');

            $table->unsignedInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');

            $table->unsignedInteger('ticket_id')->nullable();
            $table->foreign('ticket_id')->references('id')->on('tickets');

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
		Schema::drop('messages');
	}
}
