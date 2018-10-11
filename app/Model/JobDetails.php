<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class JobDetails extends Model {

	protected $table = "job_details";
	
	protected $fillable = ['employee_id','department_id','designation_id','basic_salary','job_start','job_end','verifier','leave_count','active_job'];
	
	public function Department()
	{
	    return $this->belongsTo('App\Model\System\Department','department_id');
	}
	
	public function Designation()
	{
	    return $this->belongsTo('App\Model\System\Designation','designation_id');
	}
	
	public function Employee()
	{
		return $this->belongsTo('App\Model\Employee\Employee','employee_id');
	}
	
	public function PaymentGroup()
	{
		return $this->belongsTo('App\Model\Payment\Group','payment_group');
	}

}
