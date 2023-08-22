<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateCompanyUsersTable.
 */
class CreateCompanyUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_users', function(Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('user_id');

            $table->foreign('user_id')->references('id')->on('users');

            $table->unsignedInteger('company_id');
			
            $table->foreign('company_id')->references('id')->on('companies');

            // 1: Principal, 0: 0
            $table->smallInteger('type');

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
        Schema::drop('company_users');
    }
}

