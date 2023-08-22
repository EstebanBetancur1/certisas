<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateDeclarationsTable.
 */
class CreateDeclarationsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('declarations', function(Blueprint $table) {
            $table->increments('id');

            $table->string('year')->nullable();
            $table->string('form')->nullable();
            $table->string('nro')->nullable();
            $table->string('declaration')->nullable();
            $table->date('date_emission');
            $table->date('date_payment');

            $table->string('period')->nullable();

            // 1: Rete Fuente, 2: Rete ICA, 3: Rete IVA
            $table->smallInteger('type');

            // 1: Activo, 0: Inactivo
            $table->smallInteger('status')->default(1);
            
            $table->unsignedInteger('bank_id');
			$table->foreign('bank_id')->references('id')->on('banks');

			$table->unsignedInteger('company_id');
			$table->foreign('company_id')->references('id')->on('companies');

			$table->unsignedInteger('municipality_id')->nullable();
			$table->foreign('municipality_id')->references('id')->on('municipalities');

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
		Schema::drop('declarations');
	}
}
