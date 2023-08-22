<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateCompaniesTable.
 */
class CreateCompaniesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('companies', function(Blueprint $table) {
            $table->increments('id');

            $table->string('logo')->nullable();
            $table->string('nit');
            $table->string('dv')->nullable();
            $table->string('sectional')->nullable();
            $table->string('type')->nullable();
            $table->string('name')->nullable();
            $table->string('city')->nullable();
            $table->string('address')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('file')->nullable();
            $table->integer('date')->nullable();

            $table->string('activities')->nullable();
            $table->text('responsibilities')->nullable();

            // 0: Inactivo, 1: Activo
            $table->smallInteger('status');

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
		Schema::drop('companies');
	}
}
