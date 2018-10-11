<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeavesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('leaves', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('department_id')->unsigned();
			$table->integer('employee_id')->unsigned();
			$table->integer('leave_verifier_id')->unsigned();
			$table->enum('leave_type',['General','Sick']);
			$table->text('leave_reason');
			$table->date('start_dt');
			$table->date('end_dt');
			$table->enum('leave_status',['Pending','Approved','Rejected']);
			$table->integer('leave_count')->unsigned();
			$table->boolean('extra_leave',0);
			$table->integer('created_by');
			$table->timestamps();
			
			$table->index(['department_id','employee_id','leave_verifier_id','created_by']);
			
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('leaves');
	}

}
