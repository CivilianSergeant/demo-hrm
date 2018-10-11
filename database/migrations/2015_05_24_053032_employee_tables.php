<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EmployeeTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('employees', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('employee_id',10);
			$table->string('name',100);
			$table->text('present_address')->nullable();
			$table->text('permanent_address')->nullable();
			$table->string('phone',11)->nullable();
			$table->string('email',100)->unique();
			$table->text('photo')->nullable();
			$table->enum('source',['NEWS','ONLINE','PERSON','OTHERS']);
			$table->string('source_name',100);
			$table->boolean('is_employee_working')->default(0);
			$table->boolean('probationary')->default(0);
			$table->integer('current_work_shift_id')->unsigned()->nullable();
			$table->timestamps();
			$table->softDeletes();
		});
		
		Schema::create('employee_educations',function(Blueprint $table){
			$table->integer('employee_id')->unsigned();
			$table->string('degree_name',50);
			$table->string('institution_name',50);
			$table->string('pass_year',4);
			$table->string('grade',10);
			$table->text('certificate_copy')->nullable();
			$table->timestamps();
			$table->softDeletes();
			
			$table->foreign('employee_id')->references('id')->on('employees')
				->onUpdate('cascade')->onDelete('cascade');
				
			$table->index('employee_id');
		});
		
		Schema::create('work_experiences',function(Blueprint $table){
			$table->integer('employee_id')->unsigned();
			$table->string('work_title',100);
			$table->string('org_name',100);
			$table->string('year_exp',5);
			$table->timestamps();
			$table->softDeletes();
			
			$table->foreign('employee_id')->references('id')->on('employees')
				->onUpdate('cascade')->onDelete('cascade');
				
			$table->index('employee_id');
		});
		
		Schema::create('employee_skills',function(Blueprint $table){
			$table->integer('employee_id')->unsigned();
			$table->string('title',100);
			$table->string('institution_name',100);
			$table->string('duration',10);
			$table->text('certificate_copy')->nullable();
			$table->string('remarks',50)->nullable();
			$table->timestamps();
			$table->softDeletes();
			
			$table->foreign('employee_id')->references('id')->on('employees')
				->onUpdate('cascade')->onDelete('cascade');
				
			$table->index('employee_id');
		});
		
		Schema::create('work_shifts',function(Blueprint $table){
			$table->increments('id');
			$table->string('shift_name',40)->unique();
			$table->time('start_time');
			$table->time('end_time');
			$table->timestamps();
			$table->softDeletes();
		});
		
		Schema::create('employee_workshifts',function(Blueprint $table){
			$table->integer('employee_id')->unsigned();
			$table->integer('work_shift_id')->unsigned();
			$table->string('shift_date',10);
			$table->timestamps();
			
			$table->foreign('employee_id')->references('id')->on('employees')
				->onUpdate('cascade')->onDelete('cascade');
			$table->foreign('work_shift_id')->references('id')->on('work_shifts')
				->onUpdate('cascade')->onDelete('cascade');
				
			$table->index('employee_id','work_shift_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('employee_workshifts');
		Schema::drop('work_shifts');
		Schema::drop('employee_skills');
		Schema::drop('work_experiences');
		Schema::drop('employee_educations');
		Schema::drop('employees');
	}

}
