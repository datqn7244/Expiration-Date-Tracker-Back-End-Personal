<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveWarningLimitAndPosition extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('categories', function (Blueprint $table) {
			$table->dropColumn(['expire_warning_limit', 'position']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('categories', function (Blueprint $table) {
			$table->integer('expire_warning_limit');
			$table->integer('position');
		});
	}
}
