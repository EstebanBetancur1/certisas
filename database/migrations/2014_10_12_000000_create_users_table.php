<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');

            $table->string('full_name');
            $table->string('email')->unique();
            $table->string('password');

            // 0: Inactive, 1: Active, 2: Pendiente
            $table->smallInteger('status');

            // 1: cliente, 2: asistente de administracion
            $table->smallInteger('type')->default(0);

            $table->string('image')->nullable();

            $table->string('phone')->nullable();

            $table->string('token_pre_register')->nullable();

            $table->dateTime('last_login')->nullable();
            $table->boolean('is_admin')->default(0);

            $table->boolean('email_confirmed')->default(0);
            $table->string('email_token')->nullable();
            $table->timestamp('email_token_created')->nullable();
            $table->timestamp('email_verified_at')->nullable();

            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
