<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateTemplateItemsTable.
 */
class CreateTemplateItemsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('template_items', function(Blueprint $table) {
            $table->increments('id');

            $table->string('nit');
            $table->string('name');
            $table->string('doc');
            $table->string('date');
            $table->string('base');
            $table->string('tax');
            $table->string('rate');
            $table->string('year_process');
            $table->string('period_process');
            $table->string('concept');

            // 1: Rete Fuente, 2: Rete ICA, 3: Rete IVA
            $table->smallInteger('type');

            // 1: Activo, 0: Inactivo
            $table->smallInteger('status')->default(1);

            $table->unsignedInteger('company_id');
			$table->foreign('company_id')->references('id')->on('companies');

			$table->unsignedInteger('user_id')->nullable();
			$table->foreign('user_id')->references('id')->on('users');

			$table->unsignedInteger('template_id');
			$table->foreign('template_id')->references('id')->on('templates');

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
		Schema::drop('template_items');
	}
}
