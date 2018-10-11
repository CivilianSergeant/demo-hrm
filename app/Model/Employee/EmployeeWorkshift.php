<?php namespace App\Model\Employee;

use Illuminate\Database\Eloquent\Model;

class EmployeeWorkshift extends Model {

	protected $table = "employee_workshifts";
	
	protected $fillable = ['employee_id','work_shift_id','shift_date'];
	
	public function Employee()
	{
	    return $this->belongsTo('App\Model\Employee\Employee','employee_id','id');
	}
	
	public function WorkShift()
	{
	    return $this->belongsTo('App\Model\System\WorkShift','work_shift_id');
	}

}
