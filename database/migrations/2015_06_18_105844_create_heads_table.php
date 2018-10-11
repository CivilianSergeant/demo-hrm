<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHeadsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('payment_heads', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('head_name',40);
			$table->integer('parent_head')->unsigned();
			$table->enum('job_type',['Full Time','Part Time','Intern','Contactual']);
			$table->enum('head_type',['Income','Expense']);
			$table->timestamps();
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('heads');
	}

}
