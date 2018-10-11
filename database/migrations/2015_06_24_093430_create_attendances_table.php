<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttendancesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('attendances', function(Blueprint $table)
		{
			$table->integer('employee_id')->unsigned();
			$table->integer('work_shift_id')->unsigned();
			$table->string('start_time',100);
			$table->string('end_time',100);
			$table->string('start_after',100)->nullable();
			$table->string('end_before',100)->nullable();
			$table->string('working_time',100)->nullable();
			$table->date('date');
			$table->integer('leave_id')->unsigned();
			$table->timestamps();
			
			$table->foreign('employee_id')->references('id')->on('employees')
				->onUpdate('cascade')->onDelete('cascade');
				
			$table->foreign('work_shift_id')->references('id')->on('work_shifts')
				->onUpdate('cascade')->onDelete('cascade');
				
			$table->foreign('leave_id')->references('id')->on('leaves')
				->onUpdate('cascade')->onDelete('cascade');
			
			$table->index(['employee_id','work_shift_id','leave_id']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('attendances');
	}

}
