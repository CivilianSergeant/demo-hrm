<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCandidateVacanciesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('candidate_vacancies', function(Blueprint $table)
		{
			$table->integer('candidate_id')->unsigned();
			$table->integer('vacancy_id')->unsigned();
			$table->enum('status',['Applied','Shortlist','Schedule Interview','Mark Passed','Mark Failed','Hired','Rejected']);
			$table->timestamps();
			
			$table->foreign('candidate_id')->references('id')->on('candidates')
				->onUpdate('cascade')->onDelete('cascade');
				
			$table->foreign('vacancy_id')->references('id')->on('vacancies')
				->onUpdate('cascade')->onDelete('cascade');
				
			$table->index(['candidate_id','vacancy_id']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('candidate_vacancies');
	}

}
