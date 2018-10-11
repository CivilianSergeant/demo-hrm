<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVacanciesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('vacancies', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('department_id')->unsigned();
			$table->integer('designation_id')->unsigned();
			$table->string('vacancy_name',100);
			$table->integer('hiring_manager_id')->unsigned();
			$table->integer('number_of_post')->unsigned();
			$table->boolean('publish_feed_web',1)->default(0);
			$table->text('vacancy_description');
			$table->boolean('vacancy_status',1)->default(1);
			$table->timestamps();
			$table->softDeletes();
			
			$table->foreign('department_id')->references('id')->on('departments')
				->onUpdate('cascade')->onDelete('cascade');
			
			$table->foreign('designation_id')->references('id')->on('designations')
				->onUpdate('cascade')->onDelete('cascade');
				
			$table->foreign('hiring_manager_id')->references('id')->on('employees')
				->onUpdate('cascade')->onDelete('cascade');
				
			$table->index(['department_id','designation_id','hiring_manager_id']);
				
			
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('vacancies');
	}

}
