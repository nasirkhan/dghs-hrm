<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddUserFieldsToUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function(Blueprint $table)
		{
			$table->integer('user_id');
			$table->string('username');
			$table->string('mobile');
			$table->string('user_type');
			$table->integer('org_code');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users', function(Blueprint $table)
		{
			$table->dropColumn('user_id');
			$table->dropColumn('username');
			$table->dropColumn('mobile');
			$table->dropColumn('user_type');
			$table->dropColumn('org_code');
		});
	}

}
