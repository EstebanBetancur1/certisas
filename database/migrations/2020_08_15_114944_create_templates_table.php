<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateTemplatesTable.
 */
class CreateTemplatesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('templates', function(Blueprint $table) {
            $table->increments('id');

            $table->string('title');

            // 1: Activo, 0: Inactivo
            $table->smallInteger('status')->default(1);

            // 1: Retencion a titulo de ventas, 2: Retencion a titulo de renta, 3: Industria y comercio
            $table->smallInteger('type');

            $table->unsignedInteger('company_id');
			$table->foreign('company_id')->references('id')->on('companies');

			$table->unsignedInteger('user_id')->nullable();
			$table->foreign('user_id')->references('id')->on('users');

			$table->unsignedInteger('city_id')->nullable();
			$table->foreign('city_id')->references('id')->on('cities');

			// 1: Mensual, 2: Bimestral, 3: Anual
            $table->smallInteger('period_type');

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
		Schema::drop('templates');
	}
}
