<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupPermissionsPivotTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('group_user', function(Blueprint $table)
        {
            $table->timestamps();
            $table->integer('user_id');
            $table->integer('group_id');

            $table->primary(array('user_id', 'group_id'));
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('group_user');
	}

}
