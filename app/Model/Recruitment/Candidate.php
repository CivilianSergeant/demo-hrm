<?php namespace App\Model\Recruitment;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Candidate extends Model {

    use SoftDeletes;
    
	protected $table = "candidates";
	
	protected $fillable = ['name','email','phone','vacancy_id','description','keyword','application_source','referer_name','application_dt','status'];
	
	protected $dates = ['deleted_at'];
	
	public function Vacancy()
	{
		return $this->belongsTo('App\Model\Recruitment\Vacancy','vacancy_id');
	}
	
	
	public function Histories()
	{
		return $this->hasMany('App\Model\Recruitment\CandidateVacancy','candidate_id')->where('vacancy_id',$this->vacancy_id)->orderBy('created_at','desc');
	}

}
