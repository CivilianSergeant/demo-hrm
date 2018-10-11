<?php namespace App\Model\Recruitment;

use Illuminate\Database\Eloquent\Model;

class CandidateVacancy extends Model {

	protected $table = 'candidate_vacancies';
	
	protected $fillable = ['candidate_id','vacancy_id','status'];

}
