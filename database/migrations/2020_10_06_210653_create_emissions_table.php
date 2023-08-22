<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateEmissionsTable.
 */
class CreateEmissionsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('emissions', function(Blueprint $table) {
                  $table->increments('id');

                  $table->string('agent_name')->nullable();
                  $table->string('agent_nit')->nullable();
                  $table->string('agent_dv')->nullable();
                  $table->string('agent_sectional')->nullable();
                  $table->string('agent_phone')->nullable();
                  $table->string('agent_city')->nullable();
                  $table->string('agent_address')->nullable();
                  
                  $table->string('provider_name')->nullable();
                  $table->string('provider_nit')->nullable();
                  $table->string('provider_dv')->nullable();
                  $table->string('provider_sectional')->nullable();
                  $table->string('provider_phone')->nullable();
                  $table->string('provider_city')->nullable();
                  $table->string('provider_address')->nullable();

                  $table->longText('concepts')->nullable();
                  $table->longText('docs')->nullable();
                  
                  $table->string('months')->nullable();

                  // Monto de la transaccion
                  $table->decimal('total_transaction_amount', 15, 2)->default(0.00);

                  // Monto del impuesto
                  $table->decimal('total_tax_amount', 15, 2)->default(0.00);

                  // Valor retenido
                  $table->decimal('total_amount_withheld', 15, 2)->default(0.00);

                  // 1: Rete Fuente, 2: Rete ICA, 3: Rete IVA
                  $table->smallInteger('type');

                  $table->string('year');

                  // 1: Mensual, 2: Bimestral, 3: Anual
                  $table->smallInteger('period_type');

                  $table->smallInteger('period');

                  $table->date('date_emission');

                  // 1: Activo, 0: Inactivo
                  $table->smallInteger('status')->default(1);

                  $table->unsignedInteger('company_id');
                  $table->foreign('company_id')->references('id')->on('companies');

                  $table->unsignedInteger('provider_id');
      		      $table->foreign('provider_id')->references('id')->on('companies');

                  $table->unsignedInteger('city_id')->nullable();
                  $table->foreign('city_id')->references('id')->on('cities');

                  $table->unsignedInteger('user_id')->nullable();
                  $table->foreign('user_id')->references('id')->on('users');

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
		Schema::drop('emissions');
	}
}
