<?php namespace App\Model\Recruitment;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vacancy extends Model {

	use SoftDeletes;
	
	protected $table = 'vacancies';
	
	protected $fillable = ['department_id','designation_id','vacancy_name','hiring_manager_id','number_of_post','publish_feed_web','vacancy_description','vacancy_status'];

	protected $dates = ['deleted_at'];


	public function Department()
	{
		return $this->belongsTo('App\Model\System\Department','department_id');
	}

	public function Designation()
	{
		return $this->belongsTo('App\Model\System\Designation','designation_id');
	}
	
	public function HiringManager()
	{
		return $this->belongsTo('App\Model\Employee\Employee','hiring_manager_id');
	}
}
