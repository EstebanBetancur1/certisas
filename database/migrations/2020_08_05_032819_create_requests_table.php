<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateRequestsTable.
 */
class CreateRequestsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('requests', function(Blueprint $table) {
            $table->increments('id');

            $table->string('nit');
            $table->string('dv')->nullable();
            $table->string('sectional')->nullable();
            $table->string('type')->nullable();
            $table->string('name')->nullable();
            $table->string('city')->nullable();
            $table->string('address')->nullable();
            $table->string('email')->nullable();
            $table->string('email_user')->nullable();
            $table->string('user_request')->nullable();
            $table->string('phone')->nullable();
            $table->string('file')->nullable();
            $table->integer('date')->nullable();

            $table->string('token')->nullable();

            $table->string('activities')->nullable();
            $table->text('responsibilities')->nullable();

            // 0: Sin verificar, 1: Verificado
            $table->smallInteger('status');

            // 0: Sin verificar, 1: Verificado
            $table->smallInteger('email_status');

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
		Schema::drop('requests');
	}
}
