<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateSettingsTable.
 */
class CreateSettingsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('settings', function(Blueprint $table) {
            $table->increments('id');

            $table->string('project');
            $table->string('route_login_panel');
            $table->string('email_notification');
            $table->smallInteger('maintenance_mode');
            $table->smallInteger('coming_soon_mode');

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
		Schema::drop('settings');
	}
}
