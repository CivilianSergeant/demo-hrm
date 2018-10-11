<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCandidatesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('candidates', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name',100);
			$table->string('email',255)->unique();
			$table->string('phone',11)->nullable();
			$table->text('description')->nullable();
			$table->string('keyword',300)->nullable();
			$table->enum('application_source',['NEWS','ONLINE','PERSON','OTHERS']);
			$table->string('referer_name',255)->nullable();
			$table->integer('vacancy_id')->unsigned();
			$table->date('application_dt');
			$table->enum('status',['Applied','Shortlist','Schedule Interview','Mark Passed','Mark Failed','Hired','Rejected']);
			$table->timestamps();
			$table->softDeletes();
			
			$table->foreign('vacancy_id')->references('id')->on('vacancies')
				->onUpdate('cascade')->onDelete('cascade');
				
			$table->index('vacancy_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('candidates');
	}

}
