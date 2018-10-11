<?php namespace App\Model\Employee;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model {

	protected $table = "employees";
	
	protected $fillable = ['email','name'];


    public function JobDetails()
    {
        return $this->hasMany('App\Model\JobDetails','employee_id');
    }
    
    
    
    public function ActiveJobDetails()
    {
        return $this->hasOne('App\Model\JobDetails','employee_id')->where('active_job',1);
    }
    
    public function Education()
    {
        return $this->hasMany('App\Model\Employee\EmployeeEducation','employee_id');
    }
    
    public function Skill()
    {
        return $this->hasMany('App\Model\Employee\EmployeeSkill','employee_id');
    }
    
    public function WorkExperience()
    {
        return $this->hasMany('App\Model\Employee\WorkExperience','employee_id');
    }
    
}
